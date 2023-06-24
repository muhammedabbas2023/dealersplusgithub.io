// Add event listener for Login button
document.getElementById("login-btn").addEventListener("click", function() {
    window.location.href = "login.html";
});

// Add event listener for Sign Up button
document.getElementById("signup-btn").addEventListener("click", function() {
    window.location.href = "signup.html";
});

// Use JavaScript or AJAX to fetch data from index.php and dynamically update the HTML content
fetch('index.php')
    .then(response => response.json())
    .then(data => {
        const houseContainer = document.getElementById('house-container');
        data.forEach(item => {
            const houseItem = document.createElement('div');
            houseItem.className = 'house-item';

            const imageContainer = document.createElement('div');
            imageContainer.className = 'image-container';

            const image = document.createElement('img');
            image.src = item.image1;
            image.alt = 'User Image 1';
            image.className = 'house-image';

            imageContainer.appendChild(image);
            houseItem.appendChild(imageContainer);

            const textContainer = document.createElement('div');
            textContainer.className = 'text-container';

            const idParagraph = document.createElement('p');
            idParagraph.textContent = 'ID: ' + item.id;
            textContainer.appendChild(idParagraph);

            const nameParagraph = document.createElement('p');
            nameParagraph.textContent = 'Name: ' + item.name;
            textContainer.appendChild(nameParagraph);

            const mobileParagraph = document.createElement('p');
            mobileParagraph.textContent = 'Mobile: ' + item.mobile;
            textContainer.appendChild(mobileParagraph);

            const locationParagraph = document.createElement('p');
            locationParagraph.textContent = 'Location: ' + item.location;
            textContainer.appendChild(locationParagraph);

            const rentalPriceParagraph = document.createElement('p');
            rentalPriceParagraph.textContent = 'Rental Price: ' + item.rental_price;
            textContainer.appendChild(rentalPriceParagraph);

            const descriptionParagraph = document.createElement('p');
            descriptionParagraph.textContent = 'Description: ' + item.description;
            textContainer.appendChild(descriptionParagraph);

            houseItem.appendChild(textContainer);
            houseContainer.appendChild(houseItem);
        });
    })
    .catch(error => {
        console.log('An error occurred:', error);
    });
