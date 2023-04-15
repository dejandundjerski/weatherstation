#!/usr/bin/env python
from bmp280 import BMP280

try:
    from smbus2 import SMBus
except ImportError:
    from smbus import SMBus
    
bus = SMBus(1)
bmp280 = BMP280(i2c_dev=bus)
pressure = bmp280.get_pressure()
print(pressure)
