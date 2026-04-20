<?php

add_action('wp_body_open', function() {
    custom_loader_html('windows-dots'); // Cambia aquí el tipo: 'dots', 'ripple', 'double', 'spinner', 'windows-dots'
    custom_loader_css('windows-dots');
});
add_action('wp_footer', function() {
    custom_loader_js();
});

// Agrega el HTML del loader según el tipo
function custom_loader_html($custom_loader_type) {
    switch ($custom_loader_type) {

        case 'windows-dots':
            echo '
            <div id="loader">
                <div class="loader-windows-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>';
            break;

        case 'dots':
            echo '
            <div id="loader">
                <div class="loader-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>';
            break;

        case 'ripple':
            echo '
            <div id="loader">
                <div class="loader-ripple">
                    <div></div>
                    <div></div>
                </div>
            </div>';
            break;

        case 'double':
            echo '
            <div id="loader">
                <div class="loader-double"></div>
            </div>';
            break;

        case 'spinner':
        default:
            echo '
            <div id="loader">
                <div class="spinner"></div>
            </div>';
            break;
    }
}


// Agrega el CSS según el tipo de loader
function custom_loader_css($custom_loader_type) {
    echo '<style>
    #loader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .loaded #loader {
        opacity: 0;
        visibility: hidden;
    }';

    switch ($custom_loader_type) {

        case 'windows-dots':
            echo '
            .loader-windows-dots {
                position: relative;
                width: 120px;
                height: 120px;
                left: 45px;
            }
            .loader-windows-dots span {
                position: absolute;
                width: 24px;
                height: 24px;
                background-color: var(--iw-general-color-featured);
                border-radius: 50%;
                top: 50%;
                left: 50%;
                transform-origin: -50px center;
                animation: windowsDots 1.2s linear infinite;
            }
            .loader-windows-dots span:nth-child(1) { animation-delay: 0s; }
            .loader-windows-dots span:nth-child(2) { animation-delay: 0.08s; }
            .loader-windows-dots span:nth-child(3) { animation-delay: 0.16s; }

            @keyframes windowsDots {
                0% {
                    transform: rotate(20deg) translateX(50px);
                }
                50% {
                    transform: rotate(140deg) translateX(50px);
                }
                100% {
                    transform: rotate(380deg) translateX(50px);
                }
            }';
            break;

        case 'dots':
            echo '
            .loader-dots {
                display: flex;
                gap: 10px;
            }
            .loader-dots span {
                width: 12px;
                height: 12px;
                background-color: var(--iw-general-color-featured);
                border-radius: 50%;
                animation: bounce 0.6s infinite alternate;
            }
            .loader-dots span:nth-child(2) { animation-delay: 0.2s; }
            .loader-dots span:nth-child(3) { animation-delay: 0.4s; }

            @keyframes bounce {
                to { transform: translateY(-10px); opacity: 0.5; }
            }';
            break;

        case 'ripple':
            echo '
            .loader-ripple {
                position: relative;
                width: 100px;
                height: 100px;
            }
            .loader-ripple div {
                position: absolute;
                border: 4px solid var(--iw-general-color-featured);
                border-radius: 50%;
                animation: ripple 2s infinite;
                width: 100px;
                height: 100px;
                top: 0;
                left: 0;
            }
            .loader-ripple div:nth-child(2) { animation-delay: 0.5s; }

            @keyframes ripple {
                0% { transform: scale(0.1); opacity: 1; }
                100% { transform: scale(1); opacity: 0.8; }
            }';
            break;

        case 'double':
            echo '
            .loader-double {
                width: 50px;
                height: 50px;
                position: relative;
            }
            .loader-double::before,
            .loader-double::after {
                content: "";
                box-sizing: border-box;
                position: absolute;
                inset: 0;
                border: 4px solid transparent;
                border-top-color: var(--iw-general-color-featured);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            .loader-double::after {
                border-bottom-color: #e74c3c;
                animation-direction: reverse;
                width: 35px;
                height: 35px;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }';
            // reutilizamos keyframes spin
            echo '@keyframes spin { to { transform: rotate(360deg); } }';
            break;

        case 'spinner':
        default:
            echo '
            .spinner {
                border: 8px solid #f3f3f3;
                border-top: 8px solid var(--iw-general-color-featured);
                border-radius: 50%;
                width: 60px;
                height: 60px;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                33% { transform: rotate(70deg); }
                66% { transform: rotate(300deg); }
                100% { transform: rotate(360deg); }
            }';
            break;
    }

    echo '</style>';
}


// JS para ocultar el loader
function custom_loader_js() {
    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        window.addEventListener("load", function() {
            document.body.classList.add("loaded");
        });
    });
    </script>
    ';
}
