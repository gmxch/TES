name: Run Crypto Bot

on:
  workflow_dispatch:  # Bisa dijalankan manual dari GitHub Actions

jobs:
  run-bot:
    runs-on: ubuntu-latest
    env:
      BOT_CATEGORY: ${{ secrets.BOT_CATEGORY }}  # Pilih kategori bot dari Secrets
      BOT_NAME: ${{ secrets.BOT_NAME }}          # Pilih bot dari Secrets

    steps:
      - name: Checkout repository
        uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'  # Sesuaikan dengan versi PHP yang dibutuhkan

      - name: Generate config.json
        run: |
          echo '{' > config.json
          echo '  "api_key": "${{ secrets.API_KEY }}",' >> config.json
          echo '  "cookie": "${{ secrets.COOKIE }}",' >> config.json
          echo '  "user_agent": "${{ secrets.USER_AGENT }}"' >> config.json
          echo '}' >> config.json

      - name: Check if bot exists
        run: |
          if [ ! -f bot/${{ env.BOT_CATEGORY }}/${{ env.BOT_NAME }} ]; then
            echo "ERROR: Bot not found!"
            exit 1
          fi

      - name: Run Selected Bot
        run: |
          php -d auto_prepend_file=modul/class.php bot/${{ env.BOT_CATEGORY }}/${{ env.BOT_NAME }}
