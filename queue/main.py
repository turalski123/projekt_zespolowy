from celery import Celery

import urllib.request
import os

print(os.getenv('RABBITMQ_ERLANG_COOKIE'))
print(os.getenv('RABBITMQ_DEFAULT_USER'))
print(os.getenv('RABBITMQ_DEFAULT_PASS'))
print(os.getenv('MONGO_INITDB_ROOT_USERNAME'))
print(os.getenv('MONGO_INITDB_ROOT_PASSWORD'))
