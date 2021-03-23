import hudson.Util;
pipeline {
    agent any
    stages {
        stage('Pre-Deploy') {
            steps {
                withCredentials([string(credentialsId: 'DISCORD_PROJEKT_ZESPOLOWY', variable: 'secret')]) {
                    discordSend(
                        description: "Deploy NR: ${env.BUILD_NUMBER} rozpoczety",
                        footer: '',
                        image: '',
                        link: RUN_DISPLAY_URL,
                        result: currentBuild.currentResult,
                        thumbnail: '',
                        title: 'Deploy - Projekt Zespolowy - :airplane_departure:',
                        webhookURL: "https://discord.com/api/webhooks/${secret}"
                    )
                }
            }
        }
        stage('Deploy') {
            steps {
                script {
                    withCredentials([
                        usernamePassword(credentialsId: 'VPS_PROJEKT_ZESPOLOWY', passwordVariable: 'password', usernameVariable: 'username'),
                        string(credentialsId: 'BACK_APP_SECRET', variable: 'BACK_APP_SECRET'),
                        string(credentialsId: 'BACK_MONGODB_DB', variable: 'BACK_MONGODB_DB'),
                        string(credentialsId: 'ENV_RABBITMQ_ERLANG_COOKIE', variable: 'ENV_RABBITMQ_ERLANG_COOKIE'),
                        string(credentialsId: 'ENV_RABBITMQ_DEFAULT_USER', variable: 'ENV_RABBITMQ_DEFAULT_USER'),
                        string(credentialsId: 'ENV_RABBITMQ_DEFAULT_PASS', variable: 'ENV_RABBITMQ_DEFAULT_PASS'),
                        string(credentialsId: 'ENV_MONGO_INITDB_ROOT_USERNAME', variable: 'ENV_MONGO_INITDB_ROOT_USERNAME'),
                        string(credentialsId: 'ENV_MONGO_INITDB_ROOT_PASSWORD', variable: 'ENV_MONGO_INITDB_ROOT_PASSWORD')
                    ]) {
                        def remote = [:]
                        remote.name = "VPS_PROJEKT_ZESPOLOWY"
                        remote.host = "51.38.131.167"
                        remote.allowAnyHosts = true
                        remote.user = username
                        remote.password = password
                        def BACK_APP_ENV = "prod"
                        sshCommand(
                            command: """
                                cd /home/ubuntu/projekt/projekt_zespolowy
                                docker-compose -f docker-compose.prod.yaml down
                                cat << EOF > .env
                                COMPOSE_PROJECT_NAME=prod-projekt_zespolowy

                                APP_ENV=${BACK_APP_ENV}
                                APP_SECRET=${BACK_APP_SECRET}
                                MONGODB_URL=mongodb://${ENV_MONGO_INITDB_ROOT_USERNAME}:${ENV_MONGO_INITDB_ROOT_PASSWORD}@mongo:27017
                                MONGODB_DB=${BACK_MONGODB_DB}
                                MESSENGER_TRANSPORT_DSN=amqp://${ENV_RABBITMQ_DEFAULT_USER}:${ENV_RABBITMQ_DEFAULT_PASS}@rabbitmq:5672/%2f/emails

                                RABBITMQ_ERLANG_COOKIE=${ENV_RABBITMQ_ERLANG_COOKIE}
                                RABBITMQ_DEFAULT_USER=${ENV_RABBITMQ_DEFAULT_USER}
                                RABBITMQ_DEFAULT_PASS=${ENV_RABBITMQ_DEFAULT_PASS}
                                MONGO_INITDB_ROOT_USERNAME=${ENV_MONGO_INITDB_ROOT_USERNAME}
                                MONGO_INITDB_ROOT_PASSWORD=${ENV_MONGO_INITDB_ROOT_PASSWORD}
                                CORS_ALLOW_ORIGIN='^https?://(${remote.host})(:[0-9]+)?$'
                                EOF
                                git pull
                                docker-compose -f docker-compose.prod.yaml up -d --build
                                docker-compose -f docker-compose.prod.yaml exec -T back composer install
                            """.stripIndent(),
                            remote: remote
                        )

                    }
                }
            }
        }
    }

    post {
        always {
            script {
                def buildDurationString = Util.getTimeSpanString(currentBuild.duration)

                withCredentials([string(credentialsId: 'DISCORD_PROJEKT_ZESPOLOWY', variable: 'secret')]) {
                    discordSend(
                        description: "Deploy NR: ${env.BUILD_NUMBER}\nCzas trwania: ${buildDurationString}\nStatus: ${currentBuild.result}",
                        footer: '',
                        image: '',
                        link: RUN_DISPLAY_URL,
                        result: currentBuild.currentResult,
                        thumbnail: '',
                        title: 'Deploy - Projekt Zespolowy - :airplane_arriving:',
                        webhookURL: "https://discord.com/api/webhooks/${secret}"
                    )
                }
            }
        }
    }
}
