echo "Enter Commit message:"
read msg
sh cache.sh
git add .
git commit -m "$msg"
echo ""
echo "Git Commit complete!"
echo ""

