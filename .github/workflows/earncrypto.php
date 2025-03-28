name: Run EarnCrypto Bot

on:
  workflow_dispatch:  # Hanya bisa dijalankan manual

jobs:
  run-bot:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout repository
        uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'

      - name: Generate config.json
        run: |
          echo '{' > config.json
          echo '  "cookie": "${{ secrets.COOKIE }}",' >> config.json
          echo '  "user_agent": "${{ secrets.USER_AGENT }}"' >> config.json
          echo '}' >> config.json

      - name: Run EarnCrypto Bot
        run: |
          php -d auto_prepend_file=modul/class.php bot/faucet_apikey/earn-crypto.php