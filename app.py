from flask import Flask, render_template, request, jsonify
import subprocess
import threading
import os
import sys

app = Flask(__name__, template_folder="frontend")

# Global variable for subprocess
face_recognition_process = None

root_project_dir          = f"/home/ap-spicy/guardian-pi"
recognition_dir           = f"{root_project_dir}/backend/Face Recognition"
recognition_venv          = f"{recognition_dir}/venv/bin/python"

image_capture_script      = f"{recognition_dir}/image_capture.py"
model_training_script     = f"{recognition_dir}/model_training.py"
facial_recognition_script = f"{recognition_dir}/facial_recognition.py"

encodings_file            = f"/home/ap-spicy/guardian-pi/backend/Face Recognition/encodings.pickle" #f"{recognition_dir}/encodings.pickle"
dataset_dir               = f"{recognition_dir}/dataset"

# Start Face Recognition
@app.route('/start')
def start_recognition():
    global face_recognition_process
    if face_recognition_process is None:
        face_recognition_process = subprocess.run([recognition_venv, facial_recognition_script, encodings_file])
        return jsonify({"status": "Face recognition complete"})
    return jsonify({"status": "Already running"})

# Stop Face Recognition
@app.route('/stop')
def stop_recognition():
    global face_recognition_process
    if face_recognition_process is not None:
        face_recognition_process.terminate()
        face_recognition_process = None
        return jsonify({"status": "Face recognition stopped"})
    return jsonify({"status": "Not running"})

# Capture Image
@app.route('/capture', methods=['POST'])
def capture_image():
    name = request.form.get('name', 'unknown')
    subprocess.run([recognition_venv, image_capture_script, dataset_dir, name])
    return jsonify({"status": f"Captured images for {name}"})

# Train Model
@app.route('/train')
def train_model():    
    subprocess.run([recognition_venv, model_training_script, dataset_dir, encodings_file])
    return jsonify({"status": "Model trained successfully"})

# Home Page
@app.route('/')
@app.route('/control')
def index():
    return render_template("control-panel.html")

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
