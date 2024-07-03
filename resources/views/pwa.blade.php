@laravelPWA

<style>
    :is(.dark .fi-body)::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    background-image: radial-gradient(
        ellipse at top right,
        rgba(var(--primary-950), 1) 0%,
        rgba(var(--primary-950), 0.9) 15%,
        rgba(var(--primary-900), 0.7) 30%,
        rgba(var(--primary-900), 0.5) 45%,
        rgba(var(--primary-950), 0.3) 60%,
        rgba(var(--primary-950), 0.1) 75%,
        rgba(3,7,18,0) 100%
    );
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
}

:is(.dark .dark\:bg-gray-900) {
    --tw-bg-opacity: 1;
    background-color: rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
}

    </style>