pipeline {
    agent any

    stages {
        stage('Checkout SCM') {
            steps {
                checkout scm
            }
        }
        stage('Build Docker Image') {
            steps {
                script {
                    bat 'docker build -t rajhub-php-app .'
                }
            }
        }
        stage('Run Docker Container') {
            steps {
                script {
                    // Run container mapping port 8081 on host to 80 in container
                    bat 'docker run -d -p 8081:80 rajhub-php-app'
                }
            }
        }
    }
}
