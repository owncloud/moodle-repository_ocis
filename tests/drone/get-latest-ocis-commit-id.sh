. .drone.env

echo "$1"
# Run git ls-remote to get the latest commit ID
latest_commit_id=$(curl https://api.github.com/repos/owncloud/ocis/commits/master | grep '"sha"' | head -1 | cut -d '"' -f4)
echo $latest_commit_id

# Specify the path to the drone.env file
env_file="./.drone.env"

if [[ "$1" == "master" ]]; then
  # Update the OCIS_COMMITID in the drone.env file
  sed -i "s/^OCIS_COMMITID=.*/OCIS_COMMITID=$latest_commit_id/" "$env_file"
  cat ./.drone.env
elif [[ "$1" == "stable-7.1" ]]; then
  sed -i "s/^OCIS_STABLE_COMMITID=.*/OCIS_STABLE_COMMITID=$latest_commit_id/" "$env_file"
  cat ./.drone.env
else
  echo "Invalid branch $1"
  exit 78
fi