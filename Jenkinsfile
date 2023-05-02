pipeline {
    agent any
    
    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM',
                          branches: [[name: '*/develop']],
                          userRemoteConfigs: [[url: 'https://github.com/Endorsmoch/proyecto-devops.git']]])
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