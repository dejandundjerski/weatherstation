#!/usr/bin/env python
from bmp280 import BMP280

try:
    from smbus2 import SMBus
except ImportError:
    from smbus import SMBus

# Initialise the BMP280
bus = SMBus(1)
bmp280 = BMP280(i2c_dev=bus)

temperature = bmp280.get_temperature()
pressure = bmp280.get_pressure()

output = {'inner_temperature':temperature,'pressure':pressure}
print(output)
