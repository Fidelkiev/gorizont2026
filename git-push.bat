@echo off
chcp 65001 >nul
echo ==========================================
echo GIT PUSH - Gorizont 2026
echo ==========================================
echo.

cd /d "D:\fedor\код\gorizont_clean"

echo [1/5] Initializing git repository...
git init

echo.
echo [2/5] Configuring git user...
git config user.name "Gorizont Admin"
git config user.email "admin@gorizont.com.ua"

echo.
echo [3/5] Adding all files to git...
git add -A

echo.
echo [4/5] Creating commit...
git commit -m "Initial commit: Gorizont 2026 WordPress site with PHP 8 compatibility and SEO optimization"

echo.
echo [5/5] Checking repository status...
git status
git log --oneline -3

echo.
echo ==========================================
echo LOCAL GIT REPOSITORY READY!
echo ==========================================
echo.
echo NEXT STEPS TO PUSH TO GITHUB:
echo 1. Create repository 'gorizont2026' on GitHub
echo 2. Run these commands:
echo.
echo    git remote add origin https://github.com/YOUR_USERNAME/gorizont2026.git
echo    git branch -M main
echo    git push -u origin main
echo.
echo OR use GitHub CLI:
echo    gh repo create gorizont2026 --public --source=. --push
pause
