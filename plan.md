# The Weirwood - AI Features Implementation Plan

## Project: CMSC129-Lab3-ChoateJP

---

## ✅ Already Implemented Features

### AI Chatbot (Minimum Requirements)

| Feature | Status | Files |
|---------|--------|-------|
| AI Chatbot (Three-Eyed Raven) | ✅ Complete | `app/Ai/Agents/ThreeEyedRaven.php` |
| Accepts natural language queries | ✅ | ArchivistController |
| Retrieves data from database | ✅ | Tools (ListHousesTool, GetHouseTool, QueryHistoricalTool) |
| Provides conversational responses | ✅ | ThreeEyedRaven agent |
| 5+ different inquiry types | ✅ | History, stats, status, create, update, delete |
| Error handling for unclear queries | ✅ | Graceful error messages |

**Example Queries Implemented:**
1. "Show me all houses" (List all)
2. "What's the most powerful house?" (Filter/sort)
3. "Tell me about House Stark" (Single record)
4. "Which houses have high honor?" (Filter by stat)
5. "How many houses are there?" (Count)
6. "Create a new house..." (Create via chat)
7. "Update House X..." (Update via chat)
8. "Delete House X..." (Delete via chat)

### Dummy Data

| Feature | Status | Files |
|---------|--------|-------|
| 10-20 sample records | ✅ 10 houses | `database/seeders/HousesSeeder.php` |
| Realistic and diverse data | ✅ | Full descriptions, mottos, stats |
| Database seeders | ✅ | HousesSeeder |
| Various categories/types | ✅ | Different regions, stat ranges |

### On-Page Chat Interface

| Feature | Status | Files |
|---------|--------|-------|
| Floating/embedded widget | ✅ Modal | `houses/index.blade.php` (line 87-159) |
| Message history display | ⚠️ Partial | Shows current response only |
| User input field | ✅ | Textarea + form |
| Send button | ✅ | Submit button |
| Loading indicator | ✅ | "Consulting..." state |
| Error messages | ✅ | Error div display |
| Toggle open/close | ✅ | x-show/open/close |
| Clean, intuitive UI | ✅ | Styled modal with transitions |

### Expanded Requirements (CRUD)

| Feature | Status | Files |
|---------|--------|-------|
| Create via natural language | ✅ | CreateHouseTool |
| Read via natural language | ✅ | ListHousesTool, GetHouseTool |
| Update via natural language | ✅ | UpdateHouseTool |
| Delete via natural language | ✅ | DeleteHouseTool |
| Success/failure feedback | ✅ | Tool return messages |
| Confirmation for destructive | ❌ | **NOT IMPLEMENTED** |

### Non-Functional Requirements

| Feature | Status | Files |
|---------|--------|-------|
| API keys in .env | ✅ | `config/ai.php` |
| No API keys in frontend | ✅ | All calls go through controller |
| Backend proxy | ✅ | ArchivistController |
| .env.example | ❌ | **NOT CREATED** |

### Good AI Practices

| Feature | Status | Files |
|---------|--------|-------|
| Error handling for API failures | ✅ | try-catch in controller |
| Clean project structure | ✅ | app/Ai/Agents, app/Ai/Tools |
| Separation of concerns | ✅ | Agent, Tools, Controller separate |

---

## ❌ Missing Features

### 1. Conversation Context (HIGH PRIORITY)
**Problem:** Each query is stateless - agent has no memory of previous messages

**Required for:**
- Follow-up questions ("What about House Lannister?")
- Multi-turn conversations (last 3-5 messages minimum)
- Pronoun resolution ("their power", "that house")

**Implementation:**
- Store conversation history in database (ChatSession + ChatMessage models)
- Pass last 10 messages to agent on each request
- Session/user-based conversation threads

### 2. Delete Confirmation (HIGH PRIORITY)
**Problem:** Delete executes immediately without user confirmation

**Required:**
- Confirm before destructive operations (delete, update)
- User must explicitly confirm "YES" or cancel

### 3. Message History Display (MEDIUM)
**Problem:** Only shows current response, not previous messages in conversation

**Implementation:**
- Array of messages in Alpine state
- Display message pairs (user + AI)
- Distinguish user vs AI messages

### 4. README.md (REQUIRED)
**Contents:**
- AI features description
- Model/service used (gemini)
- Setup instructions
- Environment variables
- Example queries
- Screenshots

### 5. Conversation Context (last 10 messages)
**Required for Expanded Features:**
- Handle follow-up questions
- Filter results across multiple turns
- Remember previous references

### 6. .env.example File
**Required:**
- Template with all needed environment variables
- Instructions on how to set up

---

## 🛡️ Good AI Practices to Implement

### 1. Prompt Injection Protection
- [ ] Add input sanitization (strip common patterns)
- [ ] Add system prompt isolation instruction
- [ ] Validate before passing to agent

### 2. API Security
- [ ] Rate limiting on endpoint
- [ ] Input length limits (max:500 chars)
- [ ] Sanitize error messages (don't expose details)
- [ ] Authorization for write operations

### 3. Error Handling
- [ ] Remove `$e->getMessage()` exposure
- [ ] Add timeout handling
- [ ] Graceful fallback

### 4. Model Resilience
- [ ] Add retry logic
- [ ] Timeout configuration
- [ ] Fallback provider (if configured)

---

## 📋 Implementation Checklist

### Phase 1: Database & Models
- [ ] Create `ChatSession` model
- [ ] Create `ChatMessage` model
- [ ] Add migration for chat_sessions table
- [ ] Add migration for chat_messages table

### Phase 2: Backend Integration
- [ ] Update ArchivistController to accept session_id
- [ ] Pass conversation history to agent
- [ ] Store new messages to database
- [ ] Add conversation history (last 10 messages)

### Phase 3: UI Improvements
- [ ] Add message history array to Alpine
- [ ] Render previous messages in modal
- [ ] Add user/AI message styling
- [ ] Scrollable message container

### Phase 4: Delete Confirmation
- [ ] Update DeleteHouseTool to return confirmation prompt
- [ ] Add confirmation_required to schema
- [ ] Handle confirmation in controller
- [ ] Add confirmation dialog in frontend

### Phase 5: Security & Documentation
- [ ] Add rate limiting
- [ ] Input sanitization
- [ ] Error message sanitization
- [ ] Create .env.example
- [ ] Create README.md

---

## 📝 Files Already Modified/Created

```
Modified:
- app/Http/Controllers/ArchivistController.php ✅
- app/Ai/Agents/ThreeEyedRaven.php ✅
- app/Ai/Tools/CreateHouseTool.php ✅
- app/Ai/Tools/UpdateHouseTool.php ✅
- app/Ai/Tools/DeleteHouseTool.php ✅
- app/Ai/Tools/ListHousesTool.php ✅
- app/Ai/Tools/GetHouseTool.php ✅
- app/Ai/Tools/QueryHistoricalTool.php ✅
- resources/views/houses/index.blade.php ✅
- config/ai.php ✅

Created:
- database/seeders/HousesSeeder.php ✅
- app/Ai/Agents/ThreeEyedRaven.php ✅
- app/Ai/Tools/*.php ✅
```

---

## 📝 Files to Modify for Implementation

```
Modified:
- app/Http/Controllers/ArchivistController.php
- resources/views/houses/index.blade.php
- routes/web.php (add session route if needed)

New:
- app/Models/ChatSession.php
- app/Models/ChatMessage.php
- database/migrations/*_create_chat_sessions_table.php
- database/migrations/*_create_chat_messages_table.php
- .env.example
- README.md
```

---

## Implementation Order

1. **Database Setup** → Create ChatSession + ChatMessage models and migrations
2. **Backend Update** → Pass history to agent, store messages
3. **Frontend** → Update Alpine component for message history
4. **Confirmation** → Add confirmation dialog for destructive ops
5. **Security** → Rate limiting, input sanitization
6. **Documentation** → Create .env.example and README.md

---

## Example Conversations After Implementation

### Before (Current - No Context):
```
User: "Show me the houses"
AI: "Here are the houses: Stark, Lannister, Targaryen..."

User: "Tell me about Stark"
AI: "I don't know which Stark you're referring to..." ❌
```

### After (With Context):
```
User: "Show me the houses"
AI: "Here are the houses: Stark, Lannister, Targaryen..."

User: "Tell me about Stark"
AI: "House Stark of Winterfell..." ✅

User: "What's their power level?"
AI: "Their starting power is 40..." ✅ (understands "their" = Stark)
```

---

## Confirmation Dialog Example

### Before (Current - Immediate Delete):
```
User: "Delete House Stark"
AI: "House Stark has been deleted." ❌ (executed immediately)
```

### After (With Confirmation):
```
User: "Delete House Stark"
AI: "Are you sure you want to delete House Stark? This action cannot be undone. Reply with YES to confirm or NO to cancel."

User: "YES"
AI: "House Stark has been deleted and moved to the archives." ✅
```

---

## Environment Variables Needed

```
GEMINI_API_KEY=your_api_key_here
```

---

## Setup Instructions

1. Clone repository
2. Copy `.env.example` to `.env`
3. Add your `GEMINI_API_KEY`
4. Run `composer install`
5. Run `php artisan migrate`
6. Run `php artisan db:seed` (optional)
7. Run `npm install && npm run dev`
8. Visit http://localhost:8000

---

## Example Queries to Try

1. "Show me all houses"
2. "What's the most powerful house?"
3. "Tell me about House Stark"
4. "Which houses have high honor?"
5. "Create a new house called 'House Test' with motto 'Test' and stats 50, 50, 50"
6. "Update House Test's power to 75"
7. "Delete House Test"

---

Last Updated: 2026-04-27