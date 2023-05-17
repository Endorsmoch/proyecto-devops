pipeline {
    agent any
    
    stages {
        stage('Instalar Dependencias') {
            steps {
                bat 'composer install'
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