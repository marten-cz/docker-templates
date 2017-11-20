# Colors
red=`tput setaf 1`
green=`tput setaf 2`
reset=`tput sgr0`
PROJECT=booki

# Python
DEFAULT_PYTHON := /usr/bin/python
PYTHONPATH := .
VENV := venv
PYTHON := env PYTHONPATH=$(PYTHONPATH) $(VENV)/bin/python
PIP := $(VENV)/bin/pip
PYLINT := env PYTHONPATH=$(PYTHONPATH) $(VENV)/bin/pylint --disable=I0011 --msg-template="{path}:{line}: [{msg_id}({symbol}), {obj}] {msg}"
PEP8 := env PYTHONPATH=$(PYTHONPATH) $(VENV)/bin/pep8 --repeat --ignore=E202,E501,E402
VIRTUALENV := /usr/local/bin/virtualenv
REQUIREMENTS := -r requirements.txt
ENVIRONMENT :=

GIT_REVISION := $(shell git rev-parse HEAD)

# Docker
DATE := $(shell date +%Y%m%d%H%M%S)
VERSION ?= ${DATE}.git.${GIT_REVISION}
IMAGE ?= registry.pagewiser.com/booki/api

venv:
	test -d $(VENV) || $(VIRTUALENV) -p $(DEFAULT_PYTHON) -q $(VENV)

requirements:
	if [ -d wheelhouse ]; then \
		$(PIP) install -q --no-index --find-links=wheelhouse $(REQUIREMENTS); \
	else \
		$(PIP) install -q $(REQUIREMENTS); \
	fi

bootstrap: venv requirements

clean: clean-pyc clean-build
	# pass

clean-pyc:
	find . -name '*.pyc' -exec rm --force {} +
	find . -name '*.pyo' -exec rm --force {} +
	find . -name '*~' -exec rm --force  {} +

clean-build:
	rm --force --recursive build/
	rm --force --recursive dist/
	rm --force --recursive *.egg-info

lint:
	flake8 --exclude=.tox

pep8:
	$(PEP8) --filename=*.py --ignore=W --exclude="manage.py,settings.py" --statistics --repeat $(PROJECT)

pylint:
	$(PYLINT) $(PROJECT) --max-public-methods=50 --method-rgx='[a-z_][a-z0-9_]{2,40}$$'

migrate:
	$(PYTHON) $(PROJECT)/manage.py makemigrations
	$(PYTHON) $(PROJECT)/manage.py migrate

createuser:
	echo "${green}>>> Creating a superuser ...${reset}"
	$(PYTHON) $(PROJECT)/manage.py createsuperuser --email=''

backup:
	$(PYTHON) $(PROJECT)/manage.py dumpdata api --format=json --indent=2 > fixtures.json
	echo "${green}>>> backup created successfully: fixtures.json${reset}"

load:
	$(PYTHON) $(PROJECT)/manage.py loaddata fixtures.json

run:
	$(PYTHON) $(PROJECT)/manage.py runserver

test: clean
	$(PYTHON) $(PROJECT)/manage.py test api.tests

setup: venv active

install: installdjango createproject migrate createuser magic run

build-docker: clean
	docker build -t ${IMAGE}:${VERSION} .

push-docker:
	docker push ${IMAGE}:${VERSION}

