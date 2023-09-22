#!/bin/sh

pathInit="/home/ale/site/acquistigiusti/frontend/acquistigiustitemplates"
#pathInit="/home/santa/site/livescore24.it/branches/default/"
#pathInit="/home/federico/site/livescore24.it/branches/frontendSanta/"
#pathInit="/home/simone/site/livescore24.it/branches/frontendSanta/"

cd $pathInit && cd app/Resources/layouts/m_template && ln -s ../template/* .

#Link layout app
cd $pathInit && cd app/Resources/layouts/app_template && ln -s ../template/* .

#Link views desktop
cd $pathInit && cd app/Resources/views/m_template && ln -s ../template/* .

#Link views mobile
cd $pathInit && cd app/Resources/views/app_template && ln -s ../template/* .

#
##Link dei css desktop
#cd $pathInit && cd web/css && ln -s livescore24 diretta365
#
##Link dei css mobile
#cd $pathInit && cd web/css && ln -s livescore24 m_livescore24
#
##Link css app
#cd $pathInit && cd web/css && ln -s livescore24 app_livescore24


#find . -type l >> .gitignore
