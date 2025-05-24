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
                    
                    bat 'docker run -d -p 8090:80 rajhub-php-app'
                }
            }
        }
    }
}
