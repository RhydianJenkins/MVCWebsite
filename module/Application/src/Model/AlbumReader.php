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
            $title = ucfirst(strtolower($title));   // capitalise only first char

            // create image thumbnail (from public root)
            $images = scandir($d);
            $images = array_values(preg_grep('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $images));
            $randomImg = $images[array_rand($images)];
            $thumbnail = '/img/albums/' . $albumName . '/' . $randomImg;

            // add to array
            array_push($albums, [
                'name' => $albumName,
                'title' => $title,
                'path' => $dir,
                'thumbnail' => $thumbnail,
            ]);
        }
        return $albums;
    }

    public function readAlbums($albumDir = self::ALBUM_DIR) {
        echo("reading from: " . $albumDir);
        echo("album: " . $albumFile);
    }

    public function readAlbumImages($albumFile, $albumDir = self::ALBUM_DIR) {
        echo("reading from: " . $albumDir);
        echo("album: " . $albumFile);
    }
}