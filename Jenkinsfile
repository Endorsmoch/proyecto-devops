pipeline {
    agent any
    
    stages {
        stage('Clonar Repositorio de GitHub') {
            steps {
                bat 'rmdir /S /Q PipelineJenkinsProject'
                bat 'git clone https://github.com/Endorsmoch/proyecto-devops.git'
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