#!/bin/sh

#path="/home/prod/site/cmsadmin/"
#path="/home/ale/site/cmsadmin/"
#path="/home/simone/site/miglioreprezzo/frontend"
#path="/home/staging/site/acquistigiusti/frontend"
path="/var/www/html/project"


#Rimuove tutti i link simbolici pre esistenti
cd $path && cd app && find . -maxdepth 6 -type l -exec rm -f {} \;
cd $path && cd src && find . -maxdepth 6 -type l -exec rm -f {} \;
cd $path && cd web/css && find . -maxdepth 6 -type l -exec rm -f {} \;
cd $path && cd web/images && find . -maxdepth 6 -type l -exec rm -f {} \;
cd $path && cd web/js/widget && find . -maxdepth 6 -type l -exec rm -f {} \;
cd $path && cd pluginActive && find . -maxdepth 6 -type l -exec rm -f {} \;

#Crea link delle configurazioni
cd $path && cd app/config/ && ln -s ../../pluginActive/app/config/* .
#Crea link dei layouts
cd $path && cd app/Resources/layouts/ && ln -s ../../../pluginActive/app/Resources/layouts/* .
cd $path && cd pluginActive/app/Resources/layouts/app_template && ln -s ../amp_template/* .

#Crea link simbolici ai twig padre globali da figlio a padre
cd $path && cd pluginActive/app/Resources/views/template && ln -s  ../../../../../app/Resources/views/*.twig .
cd $path && cd pluginActive/app/Resources/views/m_template && ln -s ../template/*.twig .
cd $path && cd pluginActive/app/Resources/views/app_template && ln -s ../amp_template/*.twig .
cd $path && cd pluginActive/app/Resources/views/app_template && ln -s ../template/*.twig .
cd $path && cd pluginActive/app/Resources/views/amp_template && ln -s  ../template/*.twig .

cd $path && cd pluginActive/app/Resources/views/amp_template/ABTest && ln -s ../* .
cd $path && cd pluginActive/app/Resources/views/template/ABTest && ln -s ../* .

cd $path && cd pluginActive/app/Resources/views/amp_template && ln -s ABTest/* .
cd $path && cd pluginActive/app/Resources/views/template && ln -s ABTest/* .

#poi linka tutta la cartella da padre a figlio
cd $path && cd app/Resources/views/ && ln -s ../../../pluginActive/app/Resources/views/* .

#Crea link simbolici ai Controller globali da figlio a padre
cd $path && cd pluginActive/src/AppBundle/Controller && ln -s ../../../../src/AppBundle/Controller/Global/* .
#poi linka tutti i file da padre a figlfiglioio
cd $path && cd src/AppBundle/Controller/ && ln -s ../../../pluginActive/src/AppBundle/Controller/* .

#Crea link simbolici ai Entity globali da figlio a padre 
cd $path && cd pluginActive/src/AppBundle/Entity && ln -s ../../../../src/AppBundle/Entity/Global/* .
#poi linka tutti i file da padre a figlio
cd $path && cd src/AppBundle/Entity/ && ln -s ../../../pluginActive/src/AppBundle/Entity/* .

#Crea link simbolici ai Entity globali da figlio a padre
cd $path && cd pluginActive/src/AppBundle/Repository && ln -s ../../../../src/AppBundle/Repository/Global/* .
#poi linka tutti i file da padre a figlio
cd $path && cd src/AppBundle/Repository/ && ln -s ../../../pluginActive/src/AppBundle/Repository/* .

#linka tutti i fili interni alle cartelle dei command da padre a figlio
cd $path && cd src/AppBundle/Command/ && ln -s ../../../pluginActive/src/AppBundle/Command/* .

#linka tutti i fili interni alle cartelle dei servizi da padre a figlio
cd $path && cd src/AppBundle/Service/DependencyService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/DependencyService/* .
cd $path && cd src/AppBundle/Service/ApiGettyImageService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/ApiGettyImageService/* .
cd $path && cd src/AppBundle/Service/AppService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/AppService/* .
cd $path && cd src/AppBundle/Service/CompressFilesService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/CompressFilesService/* .
cd $path && cd src/AppBundle/Service/DataService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/DataService/* .
cd $path && cd src/AppBundle/Service/FormService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/FormService/* .
cd $path && cd src/AppBundle/Service/GlobalConfigService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/GlobalConfigService/* .
cd $path && cd src/AppBundle/Service/UserUtility/ && ln -s ../../../../pluginActive/src/AppBundle/Service/UserUtility/* .
cd $path && cd src/AppBundle/Service/UtilityService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/UtilityService/* .
cd $path && cd src/AppBundle/Service/VideoApiService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/VideoApiService/* .
cd $path && cd src/AppBundle/Service/WidgetService/ && ln -s ../../../../pluginActive/src/AppBundle/Service/WidgetService/* .

#Crea i link simbolici per i js da padre a figlio intera cartella
cd $path && cd web/js/widget/ && ln -s ../../../pluginActive/web/js/widget/template .
cd $path && cd web/js/widget/ && ln -s ../../../pluginActive/web/js/widget/m_template .
cd $path && cd web/js/widget/ && ln -s ../../../pluginActive/web/js/widget/app_template .
cd $path && cd web/js/widget/ && ln -s ../../../pluginActive/web/js/widget/amp_template .



cd $path && cd pluginActive/web/css/m_template && ln -s ../template/* .
cd $path && cd pluginActive/web/css/amp_template && ln -s ../template/* .
cd $path && cd pluginActive/web/css/app_template && ln -s ../template/* .

#Crea i link simbolici per i css da padre a figlio intera cartella
cd $path && cd web/css/ && ln -s ../../pluginActive/web/css/template .
cd $path && cd web/css/ && ln -s ../../pluginActive/web/css/m_template .
cd $path && cd web/css/ && ln -s ../../pluginActive/web/css/app_template .
cd $path && cd web/css/ && ln -s ../../pluginActive/web/css/amp_template .

cd $path && cd web/images && ln -s ../../pluginActive/web/images/template/* .

#Crea il link per il robots.txt
cd $path && cd web && ln -s ../pluginActive/web/templateRobots.txt .
cd $path && cd web && ln -s ../pluginActive/web/templateRobotsXDiretta.txt .
 
#cd $path && find . -type l >> .gitignore
