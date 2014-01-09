cd ~/web/i4

# for automatically updating scas server

git checkout master
git pull origin master

git checkout beta
git pull origin beta

sh server/permissions.sh