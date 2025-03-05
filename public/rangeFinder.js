import fetch from "node-fetch";
import readline from "readline";

// Create an interface for user input
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

// Function to get coordinates using OpenStreetMap's Nominatim API
async function getCoordinates(address) {
  const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;

  const response = await fetch(url, {
    headers: { "User-Agent": "Mozilla/5.0" },
  });
  const data = await response.json();

  if (data.length > 0) {
    return {
      latitude: parseFloat(data[0].lat),
      longitude: parseFloat(data[0].lon),
    };
  } else {
    throw new Error("Location not found.");
  }
}

// Function to calculate distance using Haversine formula
function getDistance(lat1, lon1, lat2, lon2) {
  const R = 6371; // Earth radius in km
  const dLat = ((lat2 - lat1) * Math.PI) / 180;
  const dLon = ((lon2 - lon1) * Math.PI) / 180;
  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos((lat1 * Math.PI) / 180) *
      Math.cos((lat2 * Math.PI) / 180) *
      Math.sin(dLon / 2) *
      Math.sin(dLon / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return R * c; // Distance in km
}

// Function to prompt user for input and check distance
async function checkDistance() {
  rl.question("Enter first address: ", async (address1) => {
    rl.question("Enter second address: ", async (address2) => {
      try {
        const loc1 = await getCoordinates(address1);
        const loc2 = await getCoordinates(address2);

        const distance = getDistance(
          loc1.latitude,
          loc1.longitude,
          loc2.latitude,
          loc2.longitude,
        );
        console.log(`Distance: ${distance.toFixed(2)} km`);

        if (distance <= 5) {
          console.log("The locations are within 5 km.");
        } else {
          console.log("The locations are more than 5 km apart.");
        }
      } catch (error) {
        console.error("Error:", error.message);
      }
      rl.close();
    });
  });
}

// Run the function
checkDistance();
