#!/bin/bash

# Set the directory containing your video files
video_directory="/Users/lislis/Desktop/trolllike-videos-compressed"

# Check if the directory exists
if [ ! -d "$video_directory" ]; then
    echo "Error: Video directory not found."
    exit 1
fi

# Loop over video files in the directory
for video_file in "$video_directory"/*.mp4; do
    # Extract the filename without extension
    filename=$(basename "$video_file")
    filename_no_ext="${filename%.*}"

    # Specify the output JPG file
    output_image="$video_directory/$filename_no_ext.jpg"

    # Use ffmpeg to extract the first frame and save it as a JPG file
    ffmpeg -i "$video_file" -vframes 1 "$output_image"

    echo "Extracted first frame from $filename and saved as $filename_no_ext.jpg"
done

echo "Processing complete."
