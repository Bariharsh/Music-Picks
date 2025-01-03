<?php
include('_dbconnect.php');

$sql = "ALTER TABLE songs ADD COLUMN song_file VARCHAR(50)";

$result = mysqli_query($conn,$sql);

if($result){
    echo "table altered successfully";
} else {
    echo "Error inserting data";
}
?>


<script>
        document.addEventListener('DOMContentLoaded', function() {
            const audioElements = {};
            let currentPlaying = null;
            let currentAudio = null;
            let currentButton = null;
            let currentProgressBar = null;
            let progressBarInterval = null;

            // Handle star button click
            document.querySelectorAll('.star-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const songId = this.getAttribute('data-song-id');
                    const icon = this.querySelector('i');

                    // AJAX request to star/unstar the song
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'star_song.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            if (icon.classList.contains('bi-star')) {
                                icon.classList.remove('bi-star');
                                icon.classList.add('bi-star-fill');
                                icon.classList.add('starred');
                                // console.log("Button clicked");
                            } else {
                                icon.classList.remove('bi-star-fill');
                                icon.classList.add('bi-star');
                                icon.classList.remove('starred');
                            }
                        }
                    };
                    xhr.send('song_id=' + songId);
                });
            });

            // Handle play button click
            document.querySelectorAll('.play-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const songUrl = this.getAttribute('data-song-url');
                    const icon = this.querySelector('i');
                    const progressBar = this.closest('.card-body').querySelector('.progress-bar');

                    if (!audioElements[songUrl]) {
                        // Create a new audio element if it doesn't exist
                        audioElements[songUrl] = new Audio(songUrl);
                    }
                    const audio = audioElements[songUrl];


                    if (icon.classList.contains('bi-play-circle')) {
                        icon.classList.remove('bi-play-circle');
                        icon.classList.add('bi-pause-circle');
                        audio.play();
                        // Update progress bar in real time
                        progressInterval = setInterval(function() {
                            const percentage = (audio.currentTime / audio.duration) * 100;
                            progressBar.style.width = percentage + '%';
                            progressBar.setAttribute('aria-valuenow', percentage);
                        }, 100);

                        audio.onended = function() {
                            clearInterval(progressInterval);
                            icon.classList.replace('bi-pause-circle', 'bi-play-circle');
                            progressBar.style.width = '0%';
                            progressBar.setAttribute('aria-valuenow', '0');
                            currentPlaying = null;
                        };

                    } else {
                        icon.classList.remove('bi-pause-circle');
                        icon.classList.add('bi-play-circle');
                        audio.pause();

                        clearInterval(progressInterval);
                    }
                    
                });
            });
        });
    </script>