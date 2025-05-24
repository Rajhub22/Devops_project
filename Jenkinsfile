pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                git 'https://github.com/Rajhub22/Devops_project.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Build docker image using Dockerfile in repo root
                    dockerImage = docker.build("rajhub-php-app")
                }
            }
        }

        stage('Run Docker Container') {
            steps {
                script {
                    // Run container and map port 80 to host port 8080
                    dockerImage.run("-p 8080:80")
                }
            }
        }
    }
}
