from Adafruit_BME280 import *

BME280_OSAMPLE_8 = 4

sensor = BME280(t_mode=BME280_OSAMPLE_8, p_mode=BME280_OSAMPLE_8, h_mode=BME280_OSAMPLE_8, busnum=1)
# degrees = self.sensor.read_temperature()
hPa = self.sensor.read_pressure() / 100
# humidity = self.sensor.read_humidity()
print(hPa)
