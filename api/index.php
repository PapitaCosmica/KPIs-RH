<?php
/**
 * Vercel Serverless Entry Point
 * Redirects traffic to the Public Front Controller
 */

// Add logic to handle Vercel's environment if needed
// For now, we just proxy to the existing router
require __DIR__ . '/../public/index.php';
