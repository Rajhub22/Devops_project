pipeline {
    agent any

    stages {
        stage('Clone') {
            steps {
                git 'https://github.com/Rajhub22/Devops_project.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                bat 'docker build -t file-management-system .'
            }
        }

        stage('Run Container') {
            steps {
                bat 'docker run -d -p 8080:8080 --name fms-container file-management-system'
            }
        }
    }
}
