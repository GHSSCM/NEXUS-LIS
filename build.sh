#!/bin/bash

npm run generate
cp -r ./.output/public/* ./build/www/
cp -r ./lis-backend/* ./build/www/
mv ./build/www/localenv ./build/www/.env


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
exit 0

# rm -r ./build/www