echo "Enter Commit message:"
read msg
sh cache.sh
git add .
git commit -m "$msg"
echo ""
echo "Git Commit complete!"
echo ""

echo "Push and Deploy (y/n)? "
read answer
if echo "$answer" | grep -iq "^y" ;then
    sh deploy.sh
else
    echo 'Cancel commit'
fi

