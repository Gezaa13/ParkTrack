#include <ESP32Servo.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <SPI.h>
#include <MFRC522.h>
#include <PubSubClient.h>
#include <WiFi.h>

// Konfigurasi Wifi
const char* ssid = "YOUR WIFI NAME";
const char* password = "YOUR WIFI PASWORD";
const char* mqtt_server = "broker.hivemq.com / YOUR IP ADDRESS";

WiFiClient espClient;
PubSubClient client(espClient);

// Ukuran OLED
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64

// Alamat I2C OLED
#define OLED_ADDR 0x3C

// Membuat objek OLED
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, -1);

// Pin RFID
#define SS_PIN_ENTRY 5
#define SS_PIN_EXIT 15
#define RST_PIN_ENTRY 27
#define RST_PIN_EXIT 17

// RFID
MFRC522 rfidEntry(SS_PIN_ENTRY, RST_PIN_ENTRY);
MFRC522 rfidExit(SS_PIN_EXIT, RST_PIN_EXIT);

// Objek servo
Servo servoEntry;
Servo servoExit;

void connect() {
  while (!client.connected()) {
    Serial.print("Connecting MQTT...");
    Serial.print("MQTT state: ");
    Serial.println(client.state());
		display.clearDisplay();
    display.setCursor(0, 0);
    display.println("Mohon tunggu sebentar...");
    display.display();

    if (client.connect("esp32-client")) {
      Serial.println("MQTT Connected");
      client.subscribe("parking/hisan/entry/servo");
      client.subscribe("parking/hisan/exit/servo");
      client.subscribe("parking/hisan/lcd");
    } else {
      delay(2000);
    }
  }
}

void callback(char* topic, byte* payload, unsigned int length) {
  String message = "";

  for (int i = 0; i < length; i++) {
    message += (char)payload[i];
  }

  if (String(topic) == "parking/hisan/lcd") {
    display.clearDisplay();
    display.setCursor(0, 0);
    display.println(message);
    display.display();
    delay(5000);
    display.clearDisplay();
    display.setCursor(0, 0);
    display.println("Silahkan tempel kartuAnda");
    display.display();
  } else if (String(topic) == "parking/hisan/entry/servo" && message == "TRUE") {
    servoEntry.write(0);
    delay(3000);
    servoEntry.write(90);
  } else if (String(topic) == "parking/hisan/exit/servo" && message == "TRUE") {
    servoExit.write(0);
    delay(3000);
    servoExit.write(90);
  }
}

void setup() {

  Serial.begin(115200);

  // Inisialisasi OLED
  if (!display.begin(SSD1306_SWITCHCAPVCC, OLED_ADDR)) {
    Serial.println("OLED tidak terdeteksi");
    while (true)
      ;
  }

  // Koneksi Wi-Fi
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    display.clearDisplay();
    display.setCursor(0, 0);
    display.println("Mohon tunggu sebentar...");
    display.display();
  }
  Serial.println("WiFi connected");
  Serial.println(WiFi.localIP());

  client.setServer(mqtt_server, 1883);
  client.setCallback(callback);

  // Konfigurasi Device
  SPI.begin();

  rfidEntry.PCD_Init();
  rfidExit.PCD_Init();

  // Kondisi awal OLED
  display.clearDisplay();
  display.setCursor(0, 0);
  display.setTextSize(1);
  display.setTextColor(WHITE);

  // Hubungkan servo
  servoEntry.attach(32, 500, 2400);
  servoExit.attach(33, 500, 2400);
  
  servoEntry.write(90);
  servoExit.write(90);
}

void loop() {

  // Koneksi Client
  if (!client.connected()) {
    connect();
		display.clearDisplay();
		display.setCursor(0, 0);
		display.println("Mohon tunggu sebentar...");
		display.display();
  }
  client.loop();

	display.clearDisplay();
	display.setCursor(0, 0);
	display.println("Silahkan tempel kartuAnda");
	display.display();

  // RFID Entry
  if (rfidEntry.PICC_IsNewCardPresent() && rfidEntry.PICC_ReadCardSerial()) {

    // Ambil ID RFID
    String uid = "";
    for (byte i = 0; i < rfidEntry.uid.size; i++) {
      uid += String(rfidEntry.uid.uidByte[i], HEX);
    }
    uid.toUpperCase();

    client.publish("parking/hisan/entry/rfid", uid.c_str());
    Serial.println("Data terkirim");

    rfidEntry.PICC_HaltA();
  }

  // RFID Exit
  if (rfidExit.PICC_IsNewCardPresent() && rfidExit.PICC_ReadCardSerial()) {

    // Ambil ID RFID
    String uid = "";
    for (byte i = 0; i < rfidExit.uid.size; i++) {
      uid += String(rfidExit.uid.uidByte[i], HEX);
    }
    uid.toUpperCase();

    client.publish("parking/hisan/exit/rfid", uid.c_str());
    Serial.println("Data terkirim");

    rfidExit.PICC_HaltA();
  }
}
