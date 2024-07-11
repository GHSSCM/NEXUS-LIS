#!/bin/bash


# Function to handle cleanup or revert actions
cleanup() {
    echo "Ctrl+C detected. cleaning up..."

    # if this file exists, then it hasnt completed the build. revert
    path="./utils/environment.js.main" 

    if [ -e "$path" ]; then
        #revert envs
        mv utils/environment.js utils/environment.js.local
        mv utils/environment.js.main utils/environment.js
    else
        echo "Nothing to do"
    fi

    # Add your revert or cleanup logic here
    # For example, you might restore a backup, delete temporary files, etc.
    exit 1  # Exit script with status 1 (or another status code as needed)
}


# Trap SIGINT (Ctrl+C) and call cleanup function
trap cleanup SIGINT 


# Change envs to build

mv utils/environment.js utils/environment.js.main
mv utils/environment.js.local utils/environment.js

# #build
npm run generate


# Check if the npm generate command was successful
if [ $? -ne 0 ]; then
    echo "npm generate command failed. Exiting script."
    #revert envs
    mv utils/environment.js utils/environment.js.local
    mv utils/environment.js.main utils/environment.js
    exit 1
else
    echo "npm generate command succeeded."
fi

#revert envs
mv utils/environment.js utils/environment.js.local
mv utils/environment.js.main utils/environment.js







#create if not exists
www_path="./build/www"

if [ ! -d "$www_path" ]; then
    mkdir -p "$www_path"
    echo "Directory '$www_path' created."
else
    echo "Directory '$www_path' already exists."
fi


#continue
cp -r ./.output/public/* ./build/www/
cp -r ./lis-backend/* ./build/www/
cp ./build/www/localenv ./build/www/.env


# Define the source directory and the output zip file
source_dir="./build/www"
output_zipfile="./www.zip"

# Check if the source directory exists
if [ ! -d "$source_dir" ]; then
    echo "Source directory '$source_dir' does not exist!"
    exit 1
fi

# Change to the source directory and zip the contents
cd "$source_dir"
zip -r "../$output_zipfile" ./*

# Check if the zip command succeeded
if [ $? -ne 0 ]; then
    echo "Zipping failed!"
    exit 1
fi

echo "Zipping completed successfully. Output file: $output_zipfile"

pwd

cd ../../

pwd

# Check if parameter "--forOnline" is provided

if [ "$1" == "--forOnline" ]; then
    echo "Completed"
else
    
    echo "Removing ./build/www directory for local build..."
    # rm -r ./build/www
    #!/bin/bash

    # Files to include in the archive
    files_to_zip="./build/www.zip ./build/components.zip ./build/install.bat ./build/lis_st.bat ./build/lis_cpt.bat  ./build/addresses.bat ./build/lis_uz.bat ./build/php.ini"

    # Archive name
    archive_name="./build/build.zip"

    # Create the archive
    zip -r "$archive_name" $files_to_zip

    echo "Archive created: $archive_name"
fi

nautilus ./build

exit 0

