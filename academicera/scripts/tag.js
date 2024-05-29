
    // Function to get contrast color (black or white) based on luminance
    function getContrastYIQ(r, g, b) {
        r = r / 255.0;
        g = g / 255.0;
        b = b / 255.0;

        if (r <= 0.04045) r = r / 12.92;
        else r = Math.pow((r + 0.055) / 1.055, 2.4);

        if (g <= 0.04045) g = g / 12.92;
        else g = Math.pow((g + 0.055) / 1.055, 2.4);

        if (b <= 0.04045) b = b / 12.92;
        else b = Math.pow((b + 0.055) / 1.055, 2.4);

        var L = 0.2126 * r + 0.7152 * g + 0.0722 * b;
        return (L > 0.179) ? '#000000' : '#FFFFFF';
    }

    // Apply contrast color to all tags
    var tags = document.querySelectorAll('.badge');
    tags.forEach(function(tag) {
        var rgb = tag.style.backgroundColor.match(/\d+/g);
        if (rgb) {
            var textColor = getContrastYIQ(parseInt(rgb[0]), parseInt(rgb[1]), parseInt(rgb[2]));
            tag.style.color = textColor;
        }
    });
