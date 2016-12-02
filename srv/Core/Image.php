<?php

Class Srv_Core_Image
{
    /**
     * @var
     */
    private $image;
    /**
     * @var \Imagine\Gd\Imagine
     */
    private $imagine;

    /**
     * Srv_Core_Image constructor.
     */
    function __construct()
    {
        $this->imagine = new Imagine\Gd\Imagine();
    }

    function open($filename)
    {
        $this->image = $this->imagine->open($_SERVER["DOCUMENT_ROOT"] . $filename);
    }

    /**
     * @return mixed
     */
    function getSize()
    {
        return $this->image->getSize();
    }

    /**
     * @return mixed
     */
    function getWidth($box)
    {
        return $box->getWidth();
    }

    /**
     * @return mixed
     */
    function getHeight($box)
    {
        return $box->getHeight();
    }

    /**
     * @return mixed
     */
    function center($box)
    {
        return new Imagine\Image\Point\Center($box);
    }

    function getX($point)
    {
        return $point->getX();
    }

    function getY($point)
    {
        return $point->getY();
    }

    /**
     * @param $filename
     */
    function save($filename)
    {
        $this->image->save($_SERVER["DOCUMENT_ROOT"] . $filename);
    }

    /**
     * @param $point
     * @param $box
     */
    private function pr_crop($point, $box)
    {
        $this->image->crop($point, $box);
    }

    /**
     * @param $box
     */
    private function pr_resize($box)
    {
        $this->image->resize($box);
    }

    function point($x, $y)
    {
        return new Imagine\Image\Point($x, $y);
    }

    function box($w, $h)
    {
        return new Imagine\Image\Box($w, $h);
    }

    function widen($box, $width)
    {
        return $box->widen($width);
    }

    function heighten($box, $height)
    {
        return $box->heighten($height);
    }

    /**
     * Вырезание квадрата из середины
     * @param $result
     * @return $this
     */
    function crop_center_square(&$result = null)
    {
        $box = $this->getSize();
        $center = $this->center($box);
        $x = $this->getX($center);
        $y = $this->getY($center);
        $width = $this->getWidth($box);
        $height = $this->getHeight($box);

        $size = min($width, $height);
        $half_size = round($size / 2);
        $x0 = max(0, $x - $half_size);
        $y0 = max(0, $y - $half_size);

        $this->pr_crop($this->point($x0, $y0), $this->box($size, $size));

        $result = array('x' => $x0, 'y' => $y0, 'w' => $size, 'h' => $size);
        return $this;
    }

    /**
     * Изменение размера с сохранением пропорций
     * Меньшая из сторон становится $min_***
     * @param null $min_width
     * @param null $min_height
     * @return $this
     */
    function reduce_min_size($min_width = null, $min_height = null)
    {
        $box = $this->getSize();
        $width = $this->getWidth($box);
        $height = $this->getHeight($box);
        $reduce_width = 0;
        $reduce_height = 0;

        if ($min_width !== null) {
            $reduce_width = max(0, $width - $min_width);
        }

        if ($min_height !== null) {
            $reduce_height = max(0, $height - $min_height);
        }

        if ($reduce_width > 0 || $reduce_height > 0) {
            if ($reduce_width >= $reduce_height) {
                $this->pr_resize($this->heighten($box, $min_height));
            } else {
                $this->pr_resize($this->widen($box, $min_width));
            }
        }
        return $this;
    }

    /**
     * Изменение размера с сохранением пропорций
     * Большая из сторон становится $max_***
     * @param null $max_width
     * @param null $max_height
     * @return $this
     */
    function reduce_max_size($max_width = null, $max_height = null)
    {
        $box = $this->getSize();
        $width = $this->getWidth($box);
        $height = $this->getHeight($box);
        $reduce_width = 0;
        $reduce_height = 0;

        if ($max_width !== null) {
            $reduce_width = max(0, $width - $max_width);
        }

        if ($max_height !== null) {
            $reduce_height = max(0, $height - $max_height);
        }

        if ($reduce_width > 0 || $reduce_height > 0) {
            if ($reduce_width >= $reduce_height) {
                $this->pr_resize($this->widen($box, $max_width));
            } else {
                $this->pr_resize($this->heighten($box, $max_height));
            }
        }
        return $this;
    }

    /**
     * Вырезание прямоугольной области
     * @param $x
     * @param $y
     * @param $w
     * @param $h
     * @return $this
     */
    function crop($x, $y, $w, $h)
    {
        $point = $this->point($x, $y);
        $box = $this->box($w, $h);
        $this->pr_crop($point, $box);
        return $this;
    }
}