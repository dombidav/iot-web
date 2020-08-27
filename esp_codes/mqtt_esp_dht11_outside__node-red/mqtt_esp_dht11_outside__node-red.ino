#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>


int humidityData=0;
int temperatureData=0;
long lastMsg = 0;
long statusMsg = 0;
float diff = 1;
float diffHum = 1;

#define DHTPIN 2
#define DHTTYPE    DHT11  
DHT dht(DHTPIN, DHTTYPE);

IPAddress deviceIp(192, 168, 0, 43);
byte deviceMac[] = { 0xAB, 0xCD, 0xFE, 0xFE, 0xFE, 0xFE };
char* deviceId  = "sensor02"; // Name of the sensor
int updateInterval = 5000; // Interval in milliseconds
#define humidity_topic "sensor/humidityout"
#define wifi_ssid "Labor Eger24"
#define wifi_password "LaborEger2018"
#define temperature_topic "sensor/temperatureout"
#define status_topic "status/device02"
#define mqtt_user "labor"
#define mqtt_password "labor"
IPAddress mqttServer(192, 168, 0, 152);
int mqttPort = 1883;
WiFiClient espClient;
PubSubClient client(espClient);


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
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}



void setup() {
  Serial.begin(115200);
  dht.begin();
  setup_wifi();
  client.setServer(mqttServer, mqttPort);

}

bool checkBound(float newValue, float prevValue, float maxDiff) {
  return !isnan(newValue) &&
         (newValue < prevValue - maxDiff || newValue > prevValue + maxDiff);
}

bool checkBoundHum(float newValue, float prevValue, float maxDiff) {
  return !isnan(newValue) &&
         (newValue < prevValue - maxDiff || newValue > prevValue + maxDiff);
}


void loop() {
  // put your main code here, to run repeatedly:
 if (!client.connected()) {
    reconnect();
  }
 sensors_event_t event; 
  client.loop();
long now = millis();
if (now - lastMsg > 1000) {
 lastMsg = now;
 float newTemp = dht.readTemperature();
 float newHum = dht.readHumidity();

  
if (now - statusMsg > 30000) {
  statusMsg=now;
  client.publish(status_topic,"online", true);
  }

 
 if (checkBound(newTemp, temperatureData, diff)) {
      temperatureData=rint(newTemp);
      Serial.print("New temperature:");
      Serial.println(String(temperatureData).c_str());
      client.publish(temperature_topic, String(temperatureData).c_str(), true);
      delay(updateInterval);
    }
 if (checkBoundHum(newHum, humidityData, diffHum)) {
      humidityData = rint(newHum);
      Serial.print("New humidity:");
      Serial.println(String(humidityData).c_str());
      client.publish(humidity_topic, String(humidityData).c_str(), true);
      delay(updateInterval);
    }

}
}
