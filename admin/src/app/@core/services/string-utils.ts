export function capitalizeString(str: string): string {
    if (str == null || str.length === 0) {
      return str; // Return empty or null strings as is
    }
    
    return str.charAt(0).toUpperCase() + str.slice(1)
}