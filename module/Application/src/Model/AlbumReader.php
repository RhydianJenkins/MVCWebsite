<?php
namespace Application\Model;

class AlbumReader {
    /**
     * The directory (from root) of the albums.
     */
    const ALBUM_DIR = 'public/img/albums/';

    /**
     * Returns a array of albums in a given directory.
     */
    public function getAlbumFiles($dir = self::ALBUM_DIR) {
        $albums = [];
        foreach(glob($dir . '/*', GLOB_ONLYDIR) as $d) {
            // get album name from path
            $albumName = substr($d, strrpos($d, '/') + 1);

            // create pretty album title
            $title = $albumName;
            $title = preg_replace("/[^A-Za-z0-9 ]/", '', $title);   // remove non-alphabet chars

            // create image thumbnail (from public root)
            $images = scandir($d);
            $images = array_values(preg_grep('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $images));
            $randomImg = $images[array_rand($images)];
            $thumbnail = '/img/albums/' . $albumName . '/' . $randomImg;

            // count the number of images in album
            $number = count($images);

            // add to array
            array_push($albums, [
                'name' => $albumName,
                'title' => $title,
                'path' => $dir,
                'thumbnail' => $thumbnail,
                'number' => $number,
            ]);
        }
        return $albums;
    }

    public function readAlbumImages($albumFilename, $albumDir = self::ALBUM_DIR) {
        $images = [];
        $albumPath = $albumDir . $albumFilename . '/';  // from server root, not public root
        $filenames = scandir($albumPath);
        $filenames = array_values(preg_grep('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $filenames));
        $counter = 0;
        foreach($filenames as $filename) {
            $counter = $counter + 1;    // useful for displaying carousel models
            $path = '/img/albums/' . $albumFilename . '/';  // get image path (client side)
            // add to array
            array_push($images, [
                'id' => $counter,
                'path' => $path,
                'filename' => $filename,
            ]);
        }

        return $images;
    }
}