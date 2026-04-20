document.addEventListener('DOMContentLoaded', function() {
	var maxLength = 200;
	var contents = document.querySelectorAll('.iw-read-more');
	if (contents) {
		contents.forEach(function(content) {
			var whole_text = content.textContent;
			if (whole_text.length > maxLength) {
				var short_text = whole_text.substring(0, maxLength);
				var long_text = whole_text.substring(maxLength);
				content.textContent = short_text + '...';
				var readMoreButton = document.createElement('a');
				readMoreButton.classList.add('read-more-button');
				readMoreButton.classList.add('closed');
				readMoreButton.textContent = 'Leer más';
				content.appendChild(readMoreButton);
				//content.parentNode.insertBefore(readMoreButton, content.nextSibling);

				readMoreButton.addEventListener('click', function() {
					let is_closed = readMoreButton.classList.contains("closed");
					animateText(content, long_text, readMoreButton, is_closed);
					readMoreButton.classList.toggle("closed");
				});
			}
		});
	}
});

function animateText(element, text, button, is_closed) {
	if (is_closed) {
		//element.textContent = short_text + text;
		element.removeChild(button);
		element.textContent = element.textContent.substring(0, element.textContent.length - 3);
		addTextGradually(element, text, button);
		button.textContent = 'Leer menos';
	} else {
		element.removeChild(button);
		removeTextGradually(element, element.textContent, button);
		element.appendChild(button);
		button.textContent = 'Leer más';
	}
}

function addTextGradually(element, text, button) {
	var interval = 2;
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
	var maxLength = 200;
	var interval = 2;
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

