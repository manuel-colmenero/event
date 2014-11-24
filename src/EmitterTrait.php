<?php

namespace League\Event;

trait EmitterTrait
{
    /**
     * The emitter instance.
     *
     * @var EmitterInterface|null
     */
    protected $emitter;

    /**
     * Set the Emitter.
     *
     * @param EmitterInterface|null $emitter
     *
     * @return $this
     */
    public function setEmitter(EmitterInterface $emitter = null)
    {
        $this->emitter = $emitter;

        return $this;
    }

    /**
     * Get the Emitter.
     *
     * @return EmitterInterface
     */
    public function getEmitter()
    {
        if (! $this->emitter) {
            $this->emitter = new Emitter();
        }

        return $this->emitter;
    }

    /**
     * Add a listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     * @param int                        $priority
     * @return $this
     */
    public function addListener($event, $listener, $priority = ListenerAcceptorInterface::P_NORMAL)
    {
        $emitter = $this->getEmitter();
        $emitter->addListener($event, $listener, $priority);

        return $this;
    }

    /**
     * Add a one time listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     * @param int                        $priority
     * @return $this
     */
    public function addOneTimeListener($event, $listener, $priority = ListenerAcceptorInterface::P_NORMAL)
    {
        $emitter = $this->getEmitter();
        $emitter->addOneTimeListener($event, $listener, $priority);

        return $this;
    }

    /**
     * Remove a specific listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     *
     * @return $this
     */
    public function removeListener($event, $listener)
    {
        $emitter = $this->getEmitter();

        call_user_func_array([$emitter, 'removeListener'], func_get_args());

        return $this;
    }

    /**
     * Remove all listeners for an event.
     *
     * The first parameter should be the event name. All event listeners will
     * be removed.
     *
     * @param string $event
     *
     * @return $this
     */
    public function removeAllListeners($event)
    {
        $this->getEmitter()->removeAllListeners($event);

        return $this;
    }

    /**
     * Emit an event.
     *
     * @param string|EventInterface $event
     *
     * @return EventInterface
     */
    public function emit($event)
    {
        $emitter = $this->getEmitter();

        return call_user_func_array([$emitter, 'emit'], func_get_args());
    }
}