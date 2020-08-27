/*d1 mini rc52 wiring
https://discourse-cdn-sjc1.com/business5/uploads/mydevices/original/2X/e/ecedba79dc05f2c0b02b7fba8b3da2681590a11a.jpg
RST  - D3
MISO - D6
MOSI - D7
SCK  - D5
SDA  - D8
*/

#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>
#include <PubSubClient.h>

IPAddress deviceIp(192, 168, 0, 43);
byte deviceMac[] = { 0xAB, 0xCD, 0xFE, 0xFE, 0xFE, 0xFE };
String chipID=String(ESP.getChipId());
const char* deviceId =chipID.c_str(); // Name of the sensor
int updateInterval = 5000;
long lastMsg = 0;
String uid="";
String  startMsg=String("{")+"device_id"+":"+'"'+deviceId+'"'+","+"category"+":"+'"'+"RFID_READER"+'"'+"}";
#define wifi_ssid "Labor Eger24"
#define wifi_password "LaborEger2018"
#define mqtt_user "labor"
#define mqtt_password "labor"
#define rfid_topic "sensor/rfid"
#define switch_topic "rfid/led"
#define start_topic "start/rfid"
int redPin = 5;
int greenPin = 4;

IPAddress mqttServer(192, 168, 0, 150);
int mqttPort = 1883;
WiFiClient espClient;
PubSubClient client(espClient);


constexpr uint8_t RST_PIN =  0;          // Configurable, see typical pin layout above 18
constexpr uint8_t SS_PIN =  15;         // Configurable, see typical pin layout above  16

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance


void setup_wifi() {
  delay(10);
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(wifi_ssid);
  WiFi.begin(wifi_ssid, wifi_password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    // Attempt to connect
    // If you do not want to use a username and password, change next line to
    // if (client.connect("ESP8266Client")) {
    if (client.connect(deviceId, mqtt_user, mqtt_password)) {
      Serial.println("connected");
      client.subscribe(switch_topic);
      client.publish(start_topic,startMsg.c_str(),true);
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}

void callback(char* topic, byte* message, unsigned int length) {
  Serial.print("Message arrived on topic: ");
  Serial.print(topic);
  Serial.print(". Message: ");
  String messageTemp;
  
  for (int i = 0; i < length; i++) {
    Serial.print((char)message[i]);
    messageTemp += (char)message[i];
  }
  Serial.println();

  // Feel free to add more if statements to control more GPIOs with MQTT

  // If a message is received on the topic esp32/output, you check if the message is either "on" or "off". 
  // Changes the output state according to the message
  if (String(topic) == switch_topic) {
    Serial.print("Changing output to ");
    if(messageTemp == "false"){
      Serial.println("ID denied");
      digitalWrite(redPin,HIGH);
      delay(5000);
      digitalWrite(redPin,LOW);
      delay(2000);
    }
    else if(messageTemp == "true"){
      Serial.println("ID accepted");
      digitalWrite(greenPin, HIGH);
      delay(5000);
      digitalWrite(greenPin, LOW);
      delay(2000);
      
    }
  }
}
// Helper routine to dump a byte array as hex values to Serial
String dump_byte_array(byte *buffer, byte bufferSize) {
  String id="";
  for (byte i = 0; i < bufferSize; i++) {
    id+= buffer[i] < 0x10 ? "0" : "";
    id+=String(buffer[i], HEX);
  }
  return id;
}

void setup() {
  Serial.begin(115200);   // Initialize serial communications with the PC
  setup_wifi();
  pinMode(redPin,OUTPUT);
  pinMode(greenPin,OUTPUT);
  client.setServer(mqttServer, mqttPort);
  client.setCallback(callback);
  
  Serial.println("Setup");
  while (!Serial);    // Do nothing if no serial port is opened (added for Arduinos based on ATMEGA32U4)
  SPI.begin();      // Init SPI bus
  mfrc522.PCD_Init();   // Init MFRC522
  mfrc522.PCD_DumpVersionToSerial();  // Show details of PCD - MFRC522 Card Reader details
  Serial.println("Setup done");
}


void loop() {
   if (!client.connected()) {
    reconnect();
  }
  client.loop();
long now = millis();
if (now - lastMsg > 1000) {
 lastMsg = now;
  // Look for new cards
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    //delay(50);
    return;
  }

  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    //delay(50);
    return;
  }

  // Show some details of the PICC (that is: the tag/card)
  Serial.print(F("Card UID:"));
  uid=String("{")+"worker_rfid"+":"+'"'+dump_byte_array(mfrc522.uid.uidByte, mfrc522.uid.size)+'"'+","+"device_id"+":"+'"'+chipID+'"'+"}";
  Serial .print(uid);
  client.publish(rfid_topic,uid.c_str(),true);
  Serial.println();
  
  // Dump debug info about the card; PICC_HaltA() is automatically called
  //mfrc522.PICC_DumpToSerial(&(mfrc522.uid));

  
  }
}
