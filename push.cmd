@echo off
set /p var=����������:
git commit -m %var%1
git push origin master
pause