<?php

namespace AppKit\UI;

class Id
{
    /**
     * The allocation of ids by key
     *
     * @var array
     */
    private $allocation = [];

    /**
     * The block stack that is used to store the list of ID blocks
     *
     * @var array
     */
    private $blockStack = [];

    /**
     * Get the correct ID based on a provided key
     *
     * @param string $key
     * @return string
     */
    public function for($key)
    {
        // check if we have the key in the current block
        if ($this->stackValue($key) !== false) {
            // we do, but does it have a value
            if ($this->stackValue($key) == null) {
                // if not, we need to generate the value now
                $id = $this->generate($key);

                // and store it in the block stack
                $this->blockStack[count($this->blockStack) - 1][$key] = $id;

                // return the id
                return $id;
            }

            // if we already had a value in the stack, we just return it
            return $this->stackValue($key);
        }

        // otherwise, if we aren't in a block, just generate an id
        return $this->generate($key);
    }

    /**
     * Generate an ID based on a provided key
     *
     * @param string $key
     * @return string
     */
    public function generate($key)
    {
        // check if we don't already have an allocation for this key
        if (!array_key_exists($key, $this->allocation)) {
            // set the allocation to be 0 initially
            $this->allocation[$key] = 0;
        }

        // increase the allocation to the next number
        $this->allocation[$key]++;

        // get the new number in the sequence
        $sequence = $this->allocation[$key];

        // the id will start out just being the key
        $id = $key;

        // but if this isn't the first time we have seen the key
        if ($sequence > 1) {
            // we add the sequence on the end
            $id .= '-' . $sequence;
        }

        // return the generated id
        return $id;
    }

    public function stackValue($key)
    {
        foreach (array_reverse($this->blockStack) as $block) {
            if (array_key_exists($key, $block)) {
                return $block[$key];
            }
        }

        return false;
    }

    /**
     * Start an ID block
     *
     * @param string ...$keys
     * @return void
     */
    public function startBlock(...$keys)
    {
        // create an array to store this stack
        $block = [];

        // loop through the keys we want in this block
        foreach ($keys as $key) {
            // and set them all to null
            $block[$key] = null;
        }

        // add the block to the stack
        $this->blockStack[] = $block;
    }

    /**
     * End an ID block
     *
     * @return void
     */
    public function endBlock()
    {
        // remove the last item from the stack
        array_pop($this->blockStack);
    }
}
