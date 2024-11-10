<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/8.2.2/firebase-app.min.js"  referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/8.2.2/firebase-database.min.js"  referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/8.2.2/firebase-firestore.min.js"  referrerpolicy="no-referrer"></script>


<script type="module">
    const config = {
            apiKey: "{{ env('FIRE_BASE_API_KEY') }}",
            authDomain: "{{ env('FIRE_BASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIRE_BASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIRE_BASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIRE_BASE_SENDER_ID') }}",
            appId: "{{ env('FIRE_BASE_APP_ID') }}",
            measurementId: "{{ env('FIRE_BASE_MEASUREMENT_ID') }}"
        };
    firebase.initializeApp(config);
    const db = firebase.firestore();
    const collectionName = "{{ env('FIRE_BASE_COLLECTION_NAME') }}";
    const userId = "{{ auth()->user()->id }}";
    const YOUR_GEOCODING_API_KEY = "{{ env('GEOCODING_API_KEY') }}";
    const BASE_URL = "{{ env('GEOCODING_BASE_URL') }}";
    const locationInfo = document.getElementById('locationInfo');
    const container = document.querySelector('.content');

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Display coordinates while fetching the address
            locationInfo.innerHTML = `Latitude: ${latitude}, Longitude: ${longitude}`;

            // Request address using Geocoding API
            fetch(`${BASE_URL}?latlng=${latitude},${longitude}&key=${YOUR_GEOCODING_API_KEY}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "OK" && data.results[0]) {
                        const address = data.results[0].formatted_address;
                        locationInfo.innerHTML =
                            `Latitude: ${latitude}, Longitude: ${longitude}<br>Address: ${address}`;
                        container.style.display = "block"; // Show the container

                        // Prepare location data for Firestore
                        const locationData = {
                            address: address,
                            city: "ঢাকা",
                            country: "Bangladesh",
                            countryCode: "BD",
                            datetime: new Date().toISOString(),
                            distance: 0,
                            heading: 0,
                            latitude: latitude,
                            longitude: longitude,
                            speed: 0
                        };

                        // Reference to the user's document
                        const userDocRef = db.collection(collectionName).doc(userId);

                        // Check if the user document exists
                        userDocRef.get().then(doc => {
                            if (doc.exists) {
                                // User document exists, update it
                                userDocRef.collection('locations').add(locationData)
                                    .then(function(docRef) {
                                        console.log("Location added with ID: ", docRef.id);
                                    })
                                    .catch(function(error) {
                                        console.error("Error adding location: ", error);
                                    });
                            } else {
                                // User document doesn't exist, create it
                                userDocRef.set({}) // Create an empty user document
                                    .then(() => {
                                        userDocRef.collection('locations').add(locationData)
                                            .then(function(docRef) {
                                                console.log("Location added with ID: ",
                                                    docRef.id);
                                            })
                                            .catch(function(error) {
                                                console.error("Error adding location: ",
                                                    error);
                                            });
                                    })
                                    .catch(function(error) {
                                        console.error("Error creating user document: ", error);
                                    });
                            }
                        });
                    } else {
                        locationInfo.innerHTML = "Unable to fetch address.";
                    }
                })
                .catch(error => {
                    console.error("Error fetching address:", error);
                    locationInfo.innerHTML = "Error fetching address.";
                });
        }, function(error) {
            if (error.code === 1) {
                // User denied geolocation permission
                locationInfo.innerHTML = "Please allow geolocation access to use this feature. " +
                    "<button onclick='requestGeolocationPermission()'>Allow</button>";
                container.style.display = "none"; // Hide the container
            } else {
                locationInfo.innerHTML = "Error getting location: " + error.message;
            }
        });
    } else {
        locationInfo.innerHTML = "Geolocation is not supported by your browser.";
    }

    // Function to request geolocation permission again
    function requestGeolocationPermission() {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            console.log(position.coords);

            locationInfo.innerHTML = `Latitude: ${latitude}, Longitude: ${longitude}`;

            // Request address again after permission is granted
            fetch(`${BASE_URL}?latlng=${latitude},${longitude}&key=${YOUR_GEOCODING_API_KEY}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "OK" && data.results[0]) {
                        const address = data.results[0].formatted_address;
                        locationInfo.innerHTML =
                            `Latitude: ${latitude}, Longitude: ${longitude}<br>Address: ${address}`;
                        container.style.display = "block"; // Show the container

                        // Prepare location data for Firestore
                        const locationData = {
                            address: address,
                            city: "ঢাকা",
                            country: "Bangladesh",
                            countryCode: "BD",
                            datetime: new Date().toISOString(),
                            distance: 0,
                            heading: 0,
                            latitude: latitude,
                            longitude: longitude,
                            speed: 0
                        };

                        // Reference to the user's document
                        const userDocRef = db.collection(collectionName).doc(userId);

                        // Check if the user document exists
                        userDocRef.get().then(doc => {
                            if (doc.exists) {
                                // User document exists, update it
                                userDocRef.collection('locations').add(locationData)
                                    .then(function(docRef) {
                                        console.log("Location added with ID: ", docRef.id);
                                    })
                                    .catch(function(error) {
                                        console.error("Error adding location: ", error);
                                    });
                            } else {
                                // User document doesn't exist, create it
                                userDocRef.set({}) // Create an empty user document
                                    .then(() => {
                                        userDocRef.collection('locations').add(locationData)
                                            .then(function(docRef) {
                                                console.log("Location added with ID: ",
                                                    docRef.id);
                                            })
                                            .catch(function(error) {
                                                console.error("Error adding location: ",
                                                    error);
                                            });
                                    })
                                    .catch(function(error) {
                                        console.error("Error creating user document: ", error);
                                    });
                            }
                        });
                    } else {
                        locationInfo.innerHTML = "Unable to fetch address.";
                    }
                })
                .catch(error => {
                    console.error("Error fetching address:", error);
                    locationInfo.innerHTML = "Error fetching address.";
                });
        }, function(error) {
            locationInfo.innerHTML = "Error getting location: " + error.message;
        });
    }
</script>
