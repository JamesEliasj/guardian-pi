#!/bin/bash

#########
# Setup #
#########

# Exit on error
set -e

# Kill any process using port 5000 or 8000
fuser -k 5000/tcp 2>/dev/null || true
fuser -k 8000/tcp 2>/dev/null || true

# Activate Python venv
source venv/bin/activate

# Install pip requirements
pip install -r requirements.txt

################
# Run Services #
################

# Start Flask server (5000)
python app.py &
FLASK_PID=$!

# Start PHP server (8000)
php -S 0.0.0.0:8000 -t ./frontend &
PHP_PID=$!

# Cleanup function for Ctrl+C, terminal close, or kill
cleanup() {
    echo -e "\nShutting down..."
    kill $FLASK_PID $PHP_PID 2>/dev/null || true
    wait $FLASK_PID $PHP_PID 2>/dev/null || true
    exit
}

trap cleanup SIGINT SIGHUP SIGTERM

# Keep the script running
wait
