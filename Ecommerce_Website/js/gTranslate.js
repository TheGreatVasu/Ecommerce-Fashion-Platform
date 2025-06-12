document.addEventListener('DOMContentLoaded', function() {
    initGoogleTranslate();

    updateLanguageSelector();
});

function initGoogleTranslate() {
    // Create a script element for Google Translate
    const googleTranslateScript = document.createElement('script');
    googleTranslateScript.type = 'text/javascript';
    googleTranslateScript.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    document.head.appendChild(googleTranslateScript);
    
    // Add the Google Translate initialization function to the global scope
    window.googleTranslateElementInit = function() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,es,fr,hi,ar,zh-CN,de,ja,ru',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
        
        // Apply additional styling after initialization
        setTimeout(styleGoogleTranslate, 300);
        setTimeout(styleGoogleTranslate, 1000);
    };
}

function updateLanguageSelector() {
    // First, find all language selectors on the page
    const languageSelectors = document.querySelectorAll('.language-selector');
    
    if (languageSelectors.length > 0) {
        languageSelectors.forEach(selector => {
            // Create container for Google Translate
            const translateContainer = document.createElement('div');
            translateContainer.id = 'google_translate_element';
            translateContainer.className = 'google-translate-container';
            
            // Clear the selector and add our new elements
            selector.innerHTML = '';
            selector.appendChild(translateContainer);
            
            // Add a class to the parent for styling
            selector.classList.add('google-translate-active');
        });
    } else {
        // If no language selector exists, create one in the header
        const headerActions = document.querySelector('.header-actions');
        
        if (headerActions) {
            const newSelector = document.createElement('div');
            newSelector.className = 'language-selector google-translate-active';
            
            const translateContainer = document.createElement('div');
            translateContainer.id = 'google_translate_element';
            translateContainer.className = 'google-translate-container';
            
            newSelector.appendChild(translateContainer);
            
            // Insert before the first child of header-actions
            headerActions.insertBefore(newSelector, headerActions.firstChild);
        }
    }
    
    setTimeout(removeGoogleTranslateAttribution, 1000);
    setTimeout(removeGoogleTranslateAttribution, 2000);
    setTimeout(removeGoogleTranslateAttribution, 3000);
}

function removeGoogleTranslateAttribution() {
    const attribution = document.querySelector('.goog-logo-link');
    if (attribution) {
        attribution.style.display = 'none';
    }
    
    const googleDiv = document.querySelector('.goog-te-gadget');
    if (googleDiv) {
        googleDiv.removeAttribute('style');
        googleDiv.style.fontSize = '0';
    }
}

/**
 * Apply additional styling to Google Translate elements
 */
function styleGoogleTranslate() {
    // Style the combo box
    const combo = document.querySelector('.goog-te-combo');
    if (combo) {
        // Apply styling directly to the select element
        combo.style.fontFamily = 'inherit';
        combo.style.fontSize = '14px';
        combo.style.borderRadius = '8px';
        combo.style.border = '1px solid #e0e0e0';
        combo.style.padding = '8px 30px 8px 12px';
        combo.style.color = '#333';
        combo.style.backgroundColor = '#fff';
        combo.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
        combo.style.appearance = 'none';
        combo.style.webkitAppearance = 'none';
        combo.style.backgroundImage = 'url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23333\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3e%3cpolyline points=\'6 9 12 15 18 9\'%3e%3c/polyline%3e%3c/svg%3e")';
        combo.style.backgroundRepeat = 'no-repeat';
        combo.style.backgroundPosition = 'right 8px center';
        combo.style.backgroundSize = '12px';
        combo.style.cursor = 'pointer';
        combo.style.width = '180px';
    }
}

// Helper function to switch to a specific language
function switchLanguage(langCode) {
    const select = document.querySelector('.goog-te-combo');
    if (select) {
        select.value = langCode;
        
        // Trigger change event
        const event = new Event('change');
        select.dispatchEvent(event);
    }
}

// Add some custom styling for the Google Translate widget
function addCustomTranslateStyles() {
    const style = document.createElement('style');
    style.textContent = `
        .google-translate-active {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .google-translate-container {
            position: relative;
        }
        
        .goog-te-gadget {
            font-family: inherit !important;
            font-size: 0 !important;
            color: transparent !important;
        }
        
        .goog-te-banner-frame {
            display: none !important;
        }
        
        body {
            top: 0 !important;
        }
        
        /* Override Google's styling */
        .goog-te-gadget img {
            display: none !important;
        }
        
        /* Hide Google's top bar */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }
        
        /* Fix Google's extra spacing */
        iframe.goog-te-banner-frame {
            display: none !important;
        }
        
        .goog-te-gadget-simple {
            background-color: transparent !important;
            border: none !important;
            padding: 0 !important;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .goog-te-combo {
                width: 150px !important;
                font-size: 13px !important;
                padding: 6px 25px 6px 10px !important;
            }
        }
        
        @media (max-width: 576px) {
            .goog-te-combo {
                width: 120px !important;
                font-size: 12px !important;
                padding: 5px 22px 5px 8px !important;
            }
        }
    `;
    
    document.head.appendChild(style);
}

// Initialize the custom styles
addCustomTranslateStyles(); 