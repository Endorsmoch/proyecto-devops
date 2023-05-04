pipeline {
    agent any
    
    stages {
        stage('Instalar Dependencias') {
            steps {
                bat 'composer install'
            }
        }
        stage('Base de datos') {
            steps {
                bat 'copy .env.example .env'
            }
        }
        stage('Key Generate base de datos') {
            steps {
                bat 'php artisan key:generate'
            }
        }
        stage('Migrar base de datos') {
            steps {
                bat 'php artisan migrate'
            }
        }
        stage('Ejecutar Test Cases') {
            steps {
                bat 'php artisan test'
            }
        }
    }
        
    post {
        success {
            echo '¡El pipeline se ha completado exitosamente! Ejecutandose segundo pipeline...'
            build job: 'ProyectoFinalDevOpsPipelineDos'
        }
        failure {
            echo '¡El pipeline ha fallado!'
        }
    }
}