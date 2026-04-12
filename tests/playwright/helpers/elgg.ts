import { Page } from '@playwright/test';
import mysql from 'mysql2/promise';

const DB_CONFIG = {
  host: process.env.ELGG_DB_HOST || 'db',
  port: Number(process.env.ELGG_DB_PORT || 3306),
  user: process.env.ELGG_DB_USER || 'elgg',
  password: process.env.ELGG_DB_PASS || 'elgg',
  database: process.env.ELGG_DB_NAME || 'elgg',
};

export async function loginAs(page: Page, username: string, password: string = 'testpass123') {
  await page.goto('/login');
  await page.fill('input[name="username"]', username);
  await page.fill('input[name="password"]', password);
  await page.click('button[type="submit"]');
  await page.waitForURL(/\//);
}

export async function queryDb(sql: string, params: any[] = []) {
  const conn = await mysql.createConnection(DB_CONFIG);
  const [rows] = await conn.execute(sql, params);
  await conn.end();
  return rows as any[];
}

export async function getPluginSetting(pluginId: string, name: string): Promise<string | null> {
  const rows = await queryDb(
    `SELECT ps.value
       FROM elgg_entities e
       JOIN elgg_private_settings ps ON ps.entity_guid = e.guid
      WHERE e.type = 'object'
        AND e.subtype = 'plugin'
        AND ps.name = ?
        AND e.guid IN (
          SELECT entity_guid FROM elgg_private_settings
           WHERE name = 'elgg:internal:title' AND value = ?
        )`,
    [name, pluginId]
  );
  if (rows.length === 0) {
    return null;
  }
  return rows[0].value;
}
