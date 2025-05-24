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
                dir('Devops_project') {
                    script {
                        dockerImage = docker.build("rajhub-node-app")
                    }
                }
            }
        }

        stage('Run Docker Container') {
            steps {
                script {
                    dockerImage.run("-p 3000:3000")
                }
            }
        }
    }
}
