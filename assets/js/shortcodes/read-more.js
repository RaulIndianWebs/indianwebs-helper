document.addEventListener('DOMContentLoaded', function() {
	var maxLength = 200; // Cambia este valor según la cantidad de caracteres que desees mostrar inicialmente
	var contents = document.querySelectorAll('.iw-read-more');
	if (contents) {
		contents.forEach(function(content) {
			var bioContent = content.textContent;
			if (bioContent.length > maxLength) {
				var shortBio = bioContent.substring(0, maxLength);
				var longBio = bioContent.substring(maxLength);
				content.textContent = shortBio + '...';
				var readMoreButton = document.createElement('a');
				readMoreButton.classList.add('read-more-button');
				readMoreButton.textContent = 'Leer más';
				content.appendChild(readMoreButton);
				//content.parentNode.insertBefore(readMoreButton, content.nextSibling);

				readMoreButton.addEventListener('click', function() {
					if (readMoreButton.textContent === 'Leer más') {
						//content.textContent = shortBio + longBio;
						content.removeChild(readMoreButton);
						content.textContent = content.textContent.substring(0, content.textContent.length - 3);
						addTextGradually(content, longBio, readMoreButton);
						readMoreButton.textContent = 'Leer menos';
					} else {
						content.removeChild(readMoreButton);
						removeTextGradually(content, content.textContent, readMoreButton);
						content.appendChild(readMoreButton);
						readMoreButton.textContent = 'Leer más';
					}
				});
			}
		});
	}
});

function addTextGradually(element, text, button) {
	var interval = 5;
	var index = 0;
	var addCharInterval = setInterval(function() {
		if (index < text.length) {
			element.textContent += text[index];
			index++;
		} else {
			element.appendChild(button);
			clearInterval(addCharInterval);
		}
	}, interval);
}

function removeTextGradually(element, text, button) {
	var maxLength = 200; // Cambia este valor según la cantidad de caracteres que desees mostrar inicialmente
	var interval = 5; // Intervalo de tiempo en milisegundos entre la eliminación de cada carácter
	var index = text.length - 1;
	var removeCharInterval = setInterval(function() {
		if (index > maxLength) {
			element.textContent = text.substring(0, index);
			index--;
		} else {
			element.textContent += '...';
			element.appendChild(button);
			clearInterval(removeCharInterval);
		}
	}, interval);
}

