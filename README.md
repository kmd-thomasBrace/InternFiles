# InternFiles

## SonarQube/Jenkins Installation
### Prerequisites
First the following steps should be taken:
1. In your work/home directory, enter the following into the terminal:

`git clone https://github.com/thyrlian/SonarOnDocker.git`

2. When the git directory has been cloned, go to the directory and open the __docker_compose.yml__ file
3. Edit the file so the start of the file looks like the following:
```
services:
  jenkins:
    image: jenkins
    ports:
      - "8080:8080"
    restart: "always"
    volumes:
      - /var/jenkins_home
  sonarqube:
    image: sonarqube
    ports:
      - "9000:9000"
```
4. In the terminal, enter the following  ```docker-compose up```
5. In the terminal log, find the following snippet and copy and save the password somewhere:
```
jenkins_1    | *************************************************************
jenkins_1    | *************************************************************
jenkins_1    | *************************************************************
jenkins_1    | 
jenkins_1    | Jenkins initial setup is required. An admin user has been created and a password generated.
jenkins_1    | Please use the following password to proceed to installation:
jenkins_1    | 
jenkins_1    | <PASSWORD>
jenkins_1    | 
jenkins_1    | This may also be found at: /var/jenkins_home/secrets/initialAdminPassword
jenkins_1    | 
jenkins_1    | *************************************************************
jenkins_1    | *************************************************************
jenkins_1    | *************************************************************
```

### Configuring SonarQube on Jenkins
The Jenkins UI can be found at the following address `http://localhost:8080/`. Navigate to this address and follow these steps:
1. First you will be prompted for the password, use the password saved in the step before
2. Select the following options:
* Install suggested plugins
* Continue as admin
* Start using Jenkins
3. To install the sonarQube plugin do the following:
* Go to Manage Jenkins then go to Manage Plugins
* Go to Available plugins, search 'Sonar', select 'SonarQube Scanner for Jenkins' and install it without restart
4. To set up the sonarQube server, you first have to go to the sonarQube UI which can be found at the following address `http://localhost:9000/` and do the following:
* Log in using the username - admin and the password - admin
* Skip the tutorial that pops up
* In the top right corner click on the admin user and go to my account
* Go to security, and generate a token called 'Jenkins' and copy the token
5. To configure sonarQube for Jenkins do the following:
* Go to Jenkins, Managee Jenkins and then configure system
* Under SonarQube Servers, check env variables and click the add sonarQube button
* Under name enter 'sonarQube', under URL enter 'http://' followed by your local ipv4 address followed by ':9000'
* Finally under authentication token copy your authentication token and press save at the bottom of the page
* Go back to manage jenkins, then go to global tool configuration
* Under sonarQube scanner, add a sonarQube Scanner then enter 'sonarScanner' under the name field and press save at the bottom of the page

### Configuring Jenkins Project for SonarQube
1. When builiding a jenkins project first add an execute sonarqube scanner build step
2. Under analysis properties add the following where \<uniqueProjectKey\> is a unique project key and \<projectName\> is the name of the project
```
sonar.projectKey=my:<uniqueProjectKey>
sonar.projectName=<projectName>
sonar.projectVersion=1.0
sonar.sources=.
```
3. Now whenever a project is built, a link to the sonarQube results will appear in the console log of the build

## Codeception/Jenkins Installation
### Install php on Jenkins
Using the same jenkins docker, you can install php on it and run codeception tests in the jenkins build to do this you have to access the jenkins docker shell. This means the jenkins docker must first be running and when it is execute the following command in the terminal:

``` docker exec -u 0 -it sonarondocker_jenkins_1 bash ```

This opens bash in the jenkins docker. Now you can install php using the following commands:
```
apt-get update
apt-get upgrade
apt-get install -y php
apt-get install -y php-curl
```
Now php tests can be ran using the jenkins built in shell.
### Run codeception tests
The only step needed to run codeception tests on a jenkins project is to add one line 'Execute Shell' build step on the project. First codeception files need to be present in the workspace of the build for example in the image below:

![File Structure](file_structure.png?raw=true)

Then you would execute the following build step in the jenkins project to run the command 'run' on codeception:

``` ./vendor/bin/codecept run ```
