@echo off
echo Initialisation du depot Git...
git init

echo Ajout du remote GitHub...
git remote add origin https://github.com/aithalibi/project-web-medical.git

echo Ajout de tous les fichiers...
git add .

echo Creation du commit initial...
git commit -m "Initial commit - Projet web medical"

echo Push vers GitHub...
git branch -M main
git push -u origin main

echo Termine!
pause

