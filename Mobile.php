<?php
    class Mobile
    {
		private $filename = './file.txt';
		private $list;

		public function __construct() 
		{
			$this->loadData();
		}

        //------------------------------------------------------------------------------------------

		public function loadData()
		{
			$this->list = unserialize(file_get_contents($this->filename));
		}
		
        //------------------------------------------------------------------------------------------

        public function getAll()
		{
            return $this->list;
        }

        public function getItem($id)
		{
			if (!isset($this->list[$id]))
				return NULL;

            $item = $this->list[$id];
            return $item;
        }

        public function create($value)
		{
			$this->list[] = $value;
			file_put_contents($this->filename, serialize($this->list));
			return true;
        }

        public function update($id, $value)
		{
			if (!isset($this->list[$id]))
				return false;
			
			$this->list[$id] = $value;
			file_put_contents($this->filename, serialize($this->list));
			return true;
        }

        public function delete($id)
		{
			if (!isset($this->list[$id]))
				return false;
			
			unset($this->list[$id]);
			file_put_contents($this->filename, serialize($this->list));
			return true;
        }
    }
?>