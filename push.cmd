@echo off
set /p var=ÇëÊäÈëÄÚÈİ:
git add *
git commit -m %var%1
git push origin master
pause