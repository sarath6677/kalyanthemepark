import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import requests

reader = SimpleMFRC522()

try:
    print("Hold a tag near the reader")
    id, text = reader.read()
    payload = {
        'tag_id': id,
        'data': text
    }
    url = 'http://your-laravel-app-url/rfid-data'
    response = requests.post(url, data=payload)
    print(response.json())
finally:
    GPIO.cleanup()
