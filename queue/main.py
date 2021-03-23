from celery import Celery

import urllib.request
import os

print(os.getenv('ENV_RABBITMQ_DEFAULT_USER'))
print(os.getenv('ENV_RABBITMQ_DEFAULT_PASS'))
print(os.getenv('ENV_MONGO_INITDB_ROOT_USERNAME'))
print(os.getenv('ENV_MONGO_INITDB_ROOT_PASSWORD'))
