pipeline {
    agent any
    
    stages {
        stage('Clonar Repositorio de Github') {
            steps {
                checkout([$class: 'GitSCM',
                          branches: [[name: '*/develop']],
                          userRemoteConfigs: [[url: 'https://github.com/Endorsmoch/proyecto-devops.git']]])
            }
        }
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
            build job: 'ProyectoFinalDevOpsPipelineDos', parameters: [string(name: 'BUILD_NUMBER', value: "'$currentBuild.number'")]
        }
        failure {
            echo '¡El pipeline ha fallado!'
        }
    }
}