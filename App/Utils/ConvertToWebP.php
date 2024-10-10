<?php

namespace Utils;

class ConvertToWebP
{
    public function convertToWebP($source, $destination, $productSlug, $sectionId, $quality = 80)
    {
        $image = imagecreatefromstring(file_get_contents($source));
        if ($image !== false) 
        {
            // Redimensionne l'image avec des dimensions fixes pour la largeur et ajuste la hauteur en fonction du ratio d'aspect
            $fixedWidth = 900; // Par exemple, une largeur fixe pour toutes les images
            $fixedHeight = 600; // Par exemple, une hauteur fixe pour les images paysage (sera ignorée pour les portraits)
            
            $finalImage = $this->resizeImage($image, $fixedWidth, $fixedHeight);  // Redimensionner l'image
            if ($finalImage === false) {
                return false;
            }
    
            $webpImagePath = $destination . $productSlug . '-' . $sectionId . '.webp';
    
            if (imagewebp($finalImage, $webpImagePath, $quality)) 
            {
                imagedestroy($image);
                imagedestroy($finalImage);
                unlink($source);
                return $webpImagePath;
            } 
            else 
            {
                imagedestroy($image);
                imagedestroy($finalImage);
                return false;
            }
        } 
        else 
        {
            return false;
        }
    }
    

private function resizeImage($image, $fixedWidth, $fixedHeight)
{
    $originalWidth = imagesx($image);
    $originalHeight = imagesy($image);

    // Calcul du ratio d'aspect de l'image originale
    $aspectRatio = $originalWidth / $originalHeight;

    // Variables pour la nouvelle largeur et la nouvelle hauteur
    $newWidth = $fixedWidth;
    $newHeight = $fixedHeight;

    // Si l'image est au format paysage
    if ($aspectRatio > 1) {
        // Mode paysage : on fixe la largeur et on ajuste la hauteur selon le ratio d'aspect
        $newHeight = (int)($fixedWidth / $aspectRatio);
    } else {
        // Mode portrait : on fixe la largeur et ajuste la hauteur selon le ratio d'aspect
        $newHeight = (int)($fixedWidth / $aspectRatio); 
    }

    // Créer une nouvelle image redimensionnée avec les nouvelles dimensions calculées
    $resizedImage = imagecreatetruecolor($fixedWidth, $newHeight);

    // Garder la transparence si nécessaire (pour les PNG avec un canal alpha)
    imagealphablending($resizedImage, false);
    imagesavealpha($resizedImage, true);
    $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
    imagefill($resizedImage, 0, 0, $transparent);

    // Redimensionner l'image originale dans la nouvelle image
    if (!imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $fixedWidth, $newHeight, $originalWidth, $originalHeight)) {
        imagedestroy($resizedImage);
        return false;
    }

    return $resizedImage;
}
}