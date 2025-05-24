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
                sh 'docker build -t devops-image .'
            }
        }
        stage('Run Container') {
            steps {
                sh '''
                    docker stop fileapp || true
                    docker rm fileapp || true
                    docker run -d --name fileapp -p 8082:80 devops-image
                '''
            }
        }
    }
}
