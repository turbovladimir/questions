init:
	cp .env.example .env
	docker compose build --no-cache
	docker compose up --pull always -d --wait
